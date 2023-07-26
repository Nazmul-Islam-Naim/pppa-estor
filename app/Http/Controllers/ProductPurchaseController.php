<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\ProductPurchaseDetail;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use App\Models\SupplierLedger;
use App\Models\BankAccount;
use App\Models\TransactionReport;
use App\Models\PreviousStockProduct;
use Response;
use DataTables;
use Validator;
use Session;
use Auth;
use DB;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.productpurchase.index');
        $data['allbank']= BankAccount::all();
        $data['allsupplier']= Supplier::all();
        $data['allproduct']= Product::all();
        return view('purchase.product-purchase', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.productpurchase.index');
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'tender_number' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        $tok = date('Ymdhis');
        DB::beginTransaction();
        try{
            $bug=0;
            
            // getting cart product and insert into purchase tbl
            foreach ($request->addmore as $value) {
                //---------------------- product purchase detail ---------------//
                $insert= ProductPurchaseDetail::create([
                    'supplier_id' =>$request->supplier_id,
                    'tender_number' =>$request->tender_number,
                    'product_id' => $value['product_id'],
                    'unit_price' => $value['unit_price'],
                    'quantity' => $value['quantity'],
                    'tok' => $tok,
                    'purchase_date' => $request->date,
                    'status' =>1,
                    'created_by' => Auth::id(),
                ]);

                //---------------------- stock product detail ---------------//
                StockProductDetail::create([
                    'date'=>$request->date,
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity'],
                    'unit_price'=>$value['unit_price'],
                    'reason'=>'Add to Stock',
                    'tok'=>$tok,
                    'status'=>'1'
                ]);


                // creating stock from cart one by one
                $checkProduct = StockProduct::where('product_id', $value['product_id'])->count();
                

                if ($checkProduct == 1) {
                    $update=StockProduct::where('product_id', $value['product_id'])->increment('quantity', $value['quantity']);

                    // updating unit price
                    $product = DB::table('stock_products')->where('product_id', $value['product_id'])->first();
                    $updatedUnitPrice = (($product->quantity*$product->unit_price)+($value['quantity']*$value['unit_price']))/($product->quantity+$value['quantity']);
                    $update=StockProduct::where('product_id', $value['product_id'])->update(array('unit_price' => $updatedUnitPrice));
                }else{
                    $insert= StockProduct::create([
                        'product_id'=>$value['product_id'],
                        'quantity'=>$value['quantity'],
                        'unit_price'=>$value['unit_price'],
                        'status'=>'1',
                        'created_by'=>Auth::id()
                    ]);
                }
            }

            //--------------------- product purchase table ----------------//
           $insertProductPurchase= ProductPurchase::create([
                'supplier_id' =>$request->supplier_id,
                'tender_number' =>$request->tender_number,
                'amount' => $request->grandTotal,
                'tok' => $tok,
                'purchase_date' => $request->date,
                'note' => $request->note,
                'status' =>1,
                'created_by' => Auth::id(),
            ]);

             //--------------------- creating supplier ledger ----------------//
             $insertSupplierLedger= SupplierLedger::create([
                'date'=>$request->date,
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->grandTotal,
                'reason'=>'purchase',
                'tok'=>$tok,
                'status'=>1,
                'created_by'=>Auth::id()
            ]);
             //--------------------- increment supplier due ----------------//
             $incrementSupplier= Supplier::where('id',$request->supplier_id)->increment('total_due',$request->grandTotal);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Product Purchase Successfully Complete!');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('app.productpurchase.amendment');
        $data['allbank']= BankAccount::all();
        $data['allsupplier']= Supplier::all();
        $data['allproduct']= Product::all();
        $data['single_data']= ProductPurchase::where('tok',$id)->first();
        $data['alldata']= ProductPurchaseDetail::where('tok',$id)->get();
        return view('purchase.product-purchase-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('app.productpurchase.amendment');
        //-------------------- find purchase amount -----------------//
        $data = ProductPurchase::where('tok',$id)->first();
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'tender_number' => 'required',
            'purchase_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['created_by'] = Auth::id();
        $input['status'] = 1;
        $input['tok'] = $id;
        $input['amount'] = $request->grandTotal;

        DB::beginTransaction();
        try{
            $bug=0;
            //delete data
            StockProductDetail::where('tok',$id)->delete();
            foreach ($request->addmore as $value) {
                
                ProductPurchaseDetail::where([['tok',$id],['product_id',$value['product_id']]])->delete();
                $input['product_id'] = $value['product_id'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $input['tok'] = $id;
                $insert= ProductPurchaseDetail::create($input);
                
                StockProductDetail::create([
                    'date'=>date('Y-m-d', strtotime($request->purchase_date)),
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity'],
                    'unit_price'=>$value['unit_price'],
                    'reason'=>'Add to Stock',
                    'tok'=>$id,
                    'status'=>$input['status']
                ]);
                
                $checkStockProductAmount = ProductPurchaseDetail::where('product_id', $value['product_id'])->select(DB::raw('SUM(quantity*unit_price) as ttlAmount'))->first();
                $checkStockProductQnty = ProductPurchaseDetail::where('product_id', $value['product_id'])->sum('quantity');
                if ( $checkStockProductQnty == 0) {
                    $updatedUnitPrice=$checkStockProductAmount->ttlAmount/1;
                } else {
                    $updatedUnitPrice=$checkStockProductAmount->ttlAmount/$checkStockProductQnty;
                }
                
                StockProduct::where('product_id',$value['product_id'])->update(['quantity'=>$checkStockProductQnty,'unit_price'=>$updatedUnitPrice]);
                
            }
            ProductPurchase::where('tok',$id)->delete();
            SupplierLedger::where('tok',$id)->delete();
            //----------------------- decrement supplier due ------------------//
            Supplier::where('id',$data->supplier_id)->decrement('total_due',$data->amount);
            //.delete data
            
            // Inserting into purchase product table
            $insert= ProductPurchase::create($input);

            //------------------ increment supplier due -----------//
            Supplier::where('id',$request->supplier_id)->increment('total_due',$request->grandTotal);

            // Inserting into supplier_ledger table
            $insert= SupplierLedger::create([
                'date'=>date('Y-m-d', strtotime($request->purchase_date)),
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->grandTotal,
                'reason'=>'purchase',
                'tok'=>$id,
                'created_by'=>$input['created_by'],
                'status' => $input['status']
            ]);
            DB::commit();
        }catch(\Exception $e){
            //$bug=$e->errorInfo[1];
            return $e->getMessage();
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Purchase Successfully Updated !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('app.productpurchase.amendment');
        //-------------------- find purchase amount for supplier due-----------------//
        $data = ProductPurchase::where('id',$id)->first();
        DB::beginTransaction();
        try{
            $bug=0;
            // new method applied
            $getInfo = ProductPurchaseDetail::where('tok',$data->tok )->get();
            foreach ($getInfo as $value) {
                // delete
                ProductPurchaseDetail::where([['tok',$data->tok],['product_id',$value['product_id']]])->delete();
                // checking data
                $checkData=ProductPurchaseDetail::where('product_id', $value['product_id'])->count();
                if($checkData>0){
                    // update stock
                    $checkStockProductAmount = ProductPurchaseDetail::where('product_id', $value['product_id'])->select(DB::raw('SUM(quantity*unit_price) as ttlAmount'))->first();
                    $checkStockProductQnty = ProductPurchaseDetail::where('product_id', $value['product_id'])->sum('quantity');
                    if ( $checkStockProductQnty == 0) {
                        $updatedUnitPrice=$checkStockProductAmount->ttlAmount/1;
                    } else {
                        $updatedUnitPrice=$checkStockProductAmount->ttlAmount/$checkStockProductQnty;
                    }
                    
                    StockProduct::where('product_id',$value['product_id'])->update(['quantity'=>$checkStockProductQnty,'unit_price'=>$updatedUnitPrice]);
                }
            }
            
            Supplier::where('id',$data->supplier_id)->decrement('total_due',$data->amount);
            StockProductDetail::where('tok',$data->tok)->delete();
            ProductPurchase::where('tok',$data->tok)->delete();
            SupplierLedger::where('tok',$data->tok)->delete();
        
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Purchase Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    //-------------------------- show purchase report -----------------//
    public function showReport(Request $request)
    {
        Gate::authorize('app.productpurchase.report');
        if ($request->ajax()) {
            $alldata= ProductPurchase::with(['supplier','user'])
                            ->where('status', '1')
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('purchase.purchase-report');
    }

    //-------------------------- show purchase details -----------------//
    public function purchaseDetails(Request $request,$tok)
    {
        Gate::authorize('app.productpurchase.report');
        $data['single_data'] = ProductPurchase::where('tok',$tok)->first();
        $data['alldata'] = ProductPurchaseDetail::where('tok',$tok)->get();
        return view('purchase.purchase-details',$data);
    }

    //-------------------------- show purchase amendment -----------------//
    public function purchaseAmendment(Request $request)
    {
        Gate::authorize('app.productpurchase.amendment');
        if ($request->ajax()) {
            $alldata= ProductPurchase::with(['supplier','user'])
                            ->where('status', '1')
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('product-purchase.edit', $row->tok); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('purchase.purchase-amendment');
    }

    //-------------------------- delete single item form purchase -----------------//
    public function deletePurchaseItem($id,$tok){
        Gate::authorize('app.productpurchase.amendment');
        DB::beginTransaction();
        try{
            $bug=0;
            $getInfo=ProductPurchaseDetail::where([['tok',$tok],['id',$id]])->first();
            
            StockProductDetail::where([['tok',$tok],['product_id',$getInfo->product_id]])->delete();
            ProductPurchase::where('tok',$tok)->decrement('amount',$getInfo->quantity*$getInfo->unit_price);
            SupplierLedger::where('tok',$tok)->decrement('amount',$getInfo->quantity*$getInfo->unit_price);
            Supplier::where('id',$getInfo->supplier_id)->decrement('total_due',$getInfo->quantity*$getInfo->unit_price);
            ProductPurchaseDetail::where([['tok',$tok],['id',$id]])->delete();
            
            //update stock
            // pre stock and price
            $previousstockquantity = PreviousStockProduct::where('product_id', $getInfo->product_id)->sum('quantity');
            $previousstockunitprice = PreviousStockProduct::where('product_id', $getInfo->product_id)->select(DB::raw('SUM(quantity*unit_price) as prettlAmount'))->first();

            // purchase product and price
            $checkStockProductAmount = ProductPurchaseDetail::where('product_id', $getInfo->product_id)->select(DB::raw('SUM(quantity*unit_price) as ttlAmount'))->first();
            $checkStockProductQnty = ProductPurchaseDetail::where('product_id', $getInfo->product_id)->sum('quantity');

            // sell product and price
            $sellprice = StockProductDetail::where([['product_id', $getInfo->product_id],['reason','like','%Sell%']])->select(DB::raw('SUM(quantity*unit_price) as sellttlAmount'))->first();
            $sellquantity = StockProductDetail::where([['product_id', $getInfo->product_id],['reason','like','%Sell%']])->sum('quantity');
            
            $prepurchasequnatity = $previousstockquantity  + $checkStockProductQnty;
            $totalstockquantity = $prepurchasequnatity - $sellquantity;
            $prepurchaseprice = $previousstockunitprice->prettlAmount + $checkStockProductAmount->ttlAmount;
            $totalstockunitprice = $prepurchaseprice - $sellprice->sellttlAmount;
            if ( $totalstockquantity == 0) {
                $updatedUnitPrice=$totalstockunitprice/1;
            } else {
                $updatedUnitPrice=$totalstockunitprice/$totalstockquantity;
            }
            
            if (!empty($getInfo)) {
                StockProduct::where('product_id',$getInfo->product_id)->update(['quantity'=>$totalstockquantity,'unit_price'=>$updatedUnitPrice]);
            }
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }
        
        if($bug==0){
            Session::flash('flash_message','Purchase Item Successfully Deleted !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }


}

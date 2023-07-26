<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\BankAccount;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\StockProduct;
use App\Models\PreviousStockProduct;
use App\Models\StockProductDetail;
use App\Models\ProductType;
use DataTables;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class AddToPreStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.previousstock.index');
        $data['allproduct']= Product::where('status', '1')->get();
        return view('products.previous-stock-form', $data);
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
        Gate::authorize('app.previousstock.create');
        $validator = Validator::make($request->all(), [
            'stock_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        foreach ($request->addmore as $newArr) {
            $validatorItems = Validator::make($newArr, [
                'product_id' => 'required',
                'quantity' => 'required',
                'unit_price' => 'required',
            ]);

            if($validatorItems->fails()){
                Session::flash('flash_message','Please Fillup all Item Details.');
                return redirect()->back()->with('status_color','warning');
            }
        }

        $input = $request->all();
      
        $input['created_by'] = Auth::id();
        if (empty(Session::has('sellSession'))) {
            //$tok = md5(date("Ymdhis"));
            $tok = date("Ymdhis");
            // creating a session variable
            Session::put('sellSession', $tok);
        }
        $input['tok'] = Session::get('sellSession');

        DB::beginTransaction();
        try{
            $bug=0;
            $ttlQnty=0;
            foreach ($request->addmore as $value) {
                $input['product_id'] = $value['product_id'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $insert= PreviousStockProduct::create($input);

                // Creating product Stock
                $checkProduct = StockProduct::where('product_id', $value['product_id'])->get();
                if (count($checkProduct) == 1) {
                    $update=StockProduct::where('product_id', $value['product_id'])->increment('quantity', $value['quantity']);

                    foreach ($checkProduct as $checkProduct)
                    // updating unit price
                    $updatedUnitPrice = (($checkProduct->quantity*$checkProduct->unit_price)+($value['quantity']*$value['unit_price']))/($checkProduct->quantity+$value['quantity']);

                    $update=StockProduct::where('product_id', $value['product_id'])->update(array('unit_price' => $updatedUnitPrice));
                }else{
                    $insert= StockProduct::create([
                        'product_id'=>$value['product_id'],
                        'quantity'=>$value['quantity'],
                        'unit_price'=>$value['unit_price'],
                        'status'=>'1'
                    ]);
                }
                
                StockProductDetail::create([
                    'date'=>date('Y-m-d',strtotime($request->stock_date)),
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity'],
                    'unit_price'=>$value['unit_price'],
                    'reason'=>'Add to Stock(Pre Product)',
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1'
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Previous Product Successfully Added !');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //------------------------------ ajax part ----------------------//
    public function productUnit(Request $request)
    {
        $unitid = Product::where('id',$request->id)->first();
        $data['unitname'] = ProductUnit::where('id', $unitid->product_unit_id)->first();
        $data['typename'] = ProductType::where('id', $unitid->product_type_id)->first();
        $data['previousstock'] = StockProduct::where('product_id',$request->id)->first();
        return Response::json($data);
        die;
    }

    public function previousStockReport(Request $request)
    {
        Gate::authorize('app.previousstock.report');
        if ($request->ajax()) {
            $alldata= PreviousStockProduct::with(['product','product.type','product.category','product.subcategory','product.unit','product.brand'])
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('products.previous-stock-report');
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= PreviousStockProduct::whereBetween('stock_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('preStock.report', $data);
        }else {
            $data['alldata']= PreviousStockProduct::paginate(250);
            return view('preStock.report', $data);
        }
    }
}

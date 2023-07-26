<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Supplier;
use App\Models\BankAccount;
use App\Models\SupplierLedger;
use App\Models\TransactionReport;
use App\Models\ProductPurchase;
use DataTables;
use Validator;
use Session;
use Auth;
use DB;

class ProductSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.supplier.index');
        $data['alldata']= Supplier::where('status', 1)->paginate(15);
        $data['allbank']= BankAccount::where('status', 1)->get();
        return view('supplier.supplier', $data);
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
        Gate::authorize('app.supplier.create');
        if ($request->supplier_payment) {
            $validator = Validator::make($request->all(), [
                'pay_amount' => 'required|numeric',
                'payment_method' => 'required',
            ]);
            if ($validator->fails()) {
                Session::flash('flash_message', $validator->errors());
                return redirect()->back()->with('status_color','warning');
            }

            $tok = date('Ymdhis');
            DB::beginTransaction();
            try{
                $bug=0;
                // inserting into ledger table
                $insert= SupplierLedger::create([
                    'date'=>date('Y-m-d'),
                    'supplier_id'=>$request->supplier_id,
                    'amount'=>$request->pay_amount,
                    'reason'=>'payment(supplier)',
                    'tok'=> $tok,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // inserting into report table
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->payment_method,
                    'transaction_date'=>date('Y-m-d'),
                    'reason'=>'payment(supplier)',
                    'amount'=>$request->pay_amount,
                    'tok'=>$tok,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // update bank amount
                $update=DB::table('bank_accounts')->where('id', $request->payment_method)->decrement('balance', $request->pay_amount);

                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Supplier Payment Successfully Done !');
                return redirect()->back()->with('status_color','success');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
        }else{
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'email' => 'nullable|email',
            ]);
            if ($validator->fails()) {
                Session::flash('flash_message', $validator->errors());
                return redirect()->back()->with('status_color','warning');
            }

            $input = $request->all();
            $input['status'] = 1;

            DB::beginTransaction();
            try{
                $bug=0;
                $insert= Supplier::create($input);
                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Supplier Successfully Added !');
                return redirect()->back()->with('status_color','success');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
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
        Gate::authorize('app.supplier.edit');
        $data['single_data']= Supplier::findOrFail($id);
        $data['alldata']= Supplier::where('status', 1)->paginate(15);
        $data['allbank']= BankAccount::where('status', 1)->get();
        return view('supplier.supplier', $data);
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
        Gate::authorize('app.supplier.edit');
        $data=Supplier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        DB::beginTransaction();
        try{
            $bug=0;
            $data->update($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Supplier Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
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
        Gate::authorize('app.supplier.destroy');
        $data = Supplier::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Supplier Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function supplierLedger($id)
    {
        $data['alldata']= SupplierLedger::where('supplier_id', $id)->paginate(250);
        $data['singledata']= Supplier::where('id', $id)->first();
        return view('supplier.supplierLedger', $data);
    }

    
    public function supplierLedgerFilter (Request $request,$id)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= SupplierLedger::whereBetween('date', [$request->start_date, $request->end_date])->paginate(250);
            $data['singledata']= Supplier::where('id', $id)->first();
            $data['start_date']=$request->start_date;
            $data['end_date']=$request->end_date;
            return view('supplier.supplierLedger', $data);
        }
    }

    //---------------- supplier payment list old-------------------//
    public function supplierDueListOld (Request $request)
    {
        
        
        if ($request->ajax()) {
            $alldata= Supplier::where([['status', '1'],['total_due','>',0]])
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                //----------------------- get all bank ---------------//
                $option = '';
                $allbank = BankAccount::get();
                foreach ($allbank as $key => $value) {
                $option .= '<option value="'.  $value->id .'">' .  $value->bank_name . '</option>';
                }

                ob_start() ?>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="#myModal_<?php echo $row->id; ?>" data-bs-toggle="modal" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>">Payment</a>
                    </li>
                    
                      <!-- Modal -->
                      <div id="myModal_<?php echo $row->id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                           {!! Form::open(array('route' =>['supplier-payment-store'],'method'=>'POST')) !!}
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Supplier Payment</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php echo $row->name; ?>" readonly="">
                                  <input type="hidden" value="<?php echo $row->id; ?>" name="supplier_id">
                              </div>
                              <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" value="<?php echo $row->phone; ?>" readonly="">
                              </div>
                              <div class="form-group">
                                <label>Due Amount</label>
                                <input type="text" class="form-control" value="<?php echo $row->total_due; ?>" readonly="">
                              </div>
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="pay_amount" class="form-control" autocomplete="off">
                              </div>
                              <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                              </div>
                              <div class="form-group">
                                <label>Payment Method</label>
                                <select class="form-control" name="payment_method">
                                 <?php echo $option;?>
                                </select>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal">Close</button>
                              <input type="submit" name="supplier_payment" class="btn btn-success btn-sm" value="Payment">
                            </div>
                          </div>
                          {!! Form::close() !!}
                        </div>
                      </div>
                      <!-- ./Modal -->
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('supplier.supplier-payment-list');
    }
    //---------------- supplier payment list-------------------//
    public function supplierDueList (Request $request)
    {
        Gate::authorize('app.supplierreport.paymentlist');
        $data['allbank'] = BankAccount::all();
        $data['alldata'] = Supplier::where([['status', '1'],['total_due','>',0]])
                            ->orderBy('id', 'desc')
                            ->get();
                            
        return view('supplier.supplier-payment-list',$data);
    }
    //---------------- supplier payment store-------------------//
    public function supplierPaymentStore(Request $request)
    {
        Gate::authorize('app.supplierreport.paymentlist');
        $validator = Validator::make($request->all(), [
            'pay_amount' => 'required|numeric',
            'payment_method' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        //---------------------------- get supplier name -------------------//
        $getsupplier = Supplier::where('id',$request->supplier_id)->first();
        $tok = date('Ymdhis');
        DB::beginTransaction();
        try{
            $bug=0;
            //-------------------- inserting into ledger table -------------//
            $insert= SupplierLedger::create([
                'date'=> $request->date,
                'supplier_id'=>$request->supplier_id,
                'bank_id'=>$request->payment_method,
                'amount'=>$request->pay_amount,
                'reason'=>'payment supplier '. $getsupplier->name,
                'tok'=> $tok,
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            //------------------- inserting into report table ----------------//
            $insertIntoReport = TransactionReport::create([
                'bank_id'=>$request->payment_method,
                'transaction_date'=>$request->date,
                'reason'=>'payment supplier '. $getsupplier->name,
                'amount'=>$request->pay_amount,
                'tok'=>$tok,
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            // ------------------- increment supplier payment amount ---------------------//
            $incrementpayment = Supplier::where('id', $request->supplier_id)->increment('total_payment', $request->pay_amount);

            // ------------------- decrement supplier due amount ---------------------//
            $incrementpayment = Supplier::where('id', $request->supplier_id)->decrement('total_due', $request->pay_amount);

            // ------------------- decrement bank amount ---------------------//
            $decrementbank = BankAccount::where('id', $request->payment_method)->decrement('balance', $request->pay_amount);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Supplier Payment Successfully Done !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    //---------------- supplier Due report-------------------//
    public function supplierDueReport (Request $request)
    {
        Gate::authorize('app.supplierreport.duereport');
        if ($request->ajax()) {
            $alldata= Supplier::where([['status', '1'],['total_due','>',0]])
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('supplier.supplier-due-report');
    }
    //---------------- supplier payment report-------------------//
    public function supplierPaymentReport (Request $request)
    {
        Gate::authorize('app.supplierreport.paymentreport');
        if ($request->ajax()) {
            $alldata= SupplierLedger::with(['supplier','bank'])
                            ->where([['status', '1'],['reason','like','%payment supplier%']])
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('supplier.supplier-payment-report');
    }
    //---------------- supplier payment amendment-------------------//
    public function supplierPaymentAmendment (Request $request)
    {
        Gate::authorize('app.supplierreport.paymentamendment');
        if ($request->ajax()) {
            $alldata= SupplierLedger::with(['supplier','bank'])
                            ->where([['status', '1'],['reason','like','%payment supplier%']])
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('supplier-payment-edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('supplier.supplier-payment-amendment');
    }
    //---------------- supplier payment edit -------------------//
    public function paymentEdit (Request $request, $id)
    {
        Gate::authorize('app.supplierreport.paymentamendment');
        $data['allbank'] = BankAccount::all();
        $data['single_data'] = SupplierLedger::where('id',$id)->first();
                            
        return view('supplier.supplier-payment-form',$data);
    }
    //---------------- supplier payment update-------------------//
    public function paymentUpdate(Request $request, $id)
    {
        Gate::authorize('app.supplierreport.paymentamendment');
        $getid=supplierLedger::where('id',$id)->first();

        $validator = Validator::make($request->all(), [
            'pay_amount' => 'required|numeric',
            'payment_method' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        DB::beginTransaction();
        try{
            $bug=0;
            //--------------------------- decrement wrong payment ------------//
            $decrementbank = BankAccount::where('id',$getid->bank_id)->increment('balance',$getid->amount);
            $decrementtrnx = TransactionReport::where('tok',$getid->tok)->decrement('amount',$getid->amount);
            $incrementsupplierdue = Supplier::where('id',$getid->supplier_id)->increment('total_due',$getid->amount);
            $decrementsupplierpayment = Supplier::where('id',$getid->supplier_id)->decrement('total_payment',$getid->amount);
            $decrementsupplierledger = SupplierLedger::where('id',$getid->id)->decrement('amount',$getid->amount);

            //--------------------------- increment right payment ------------//
            $incrementbank = BankAccount::where('id',$request->bank_id)->decrement('balance',$request->pay_amount);
            $incrementtrnx = TransactionReport::where('tok',$request->tok)->increment('amount',$request->pay_amount);
            $decrementsupplierdue = Supplier::where('id',$request->supplier_id)->decrement('total_due',$request->pay_amount);
            $incrementsupplierpayment = Supplier::where('id',$request->supplier_id)->increment('total_payment',$request->pay_amount);
            $incrementsupplierledger = SupplierLedger::where('id',$request->id)->increment('amount',$request->pay_amount);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            // dd($e->getMessage());
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Supplier Payment Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    //---------------- supplier payment destroy-------------------//
    public function paymentDestroy(Request $request, $id)
    {
        Gate::authorize('app.supplierreport.paymentamendment');
        $getid=supplierLedger::where('id',$id)->first();
        DB::beginTransaction();
        try{
            $bug=0;
            //--------------------------- decrement wrong payment ------------//
            $decrementbank = BankAccount::where('id',$getid->bank_id)->increment('balance',$getid->amount);
            $incrementsupplierdue = Supplier::where('id',$getid->supplier_id)->increment('total_due',$getid->amount);
            $decrementsupplierpayment = Supplier::where('id',$getid->supplier_id)->decrement('total_payment',$getid->amount);
            //--------------------------- destroy ledger --------------------//
            $decrementtrnx = TransactionReport::where('tok',$getid->tok)->delete();
            $decrementsupplierledger = SupplierLedger::where('id',$getid->id)->delete();
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            dd();
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Supplier Payment Deleted !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

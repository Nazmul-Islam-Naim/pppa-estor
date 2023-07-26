<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;
include(app_path() . '/library/common.php');

class BankDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'deposit_amount' => 'required|gt:0',
            'transaction_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();
        $input['status'] = 1;
        $input['amount'] = $request->deposit_amount;
        $input['reason'] = 'deposit(bank)';
        $input['keyword'] = 'Bank Deposit';
        $input['tok'] = date('Ymdhis');
        $input['created_by'] = Auth::id();
        $input['transaction_date'] = dateFormateForDB($request->transaction_date);

        DB::beginTransaction();
        try{
            $bug=0;
            $insertIntoReport = TransactionReport::create($input);

            $update=DB::table('bank_accounts')->where('id', $request->bank_id)->increment('balance', $request->deposit_amount);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Deposit Successfully Added !');
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

    public function bankDeposit(Request $request, $id)
    {
        $data['alldata'] = BankAccount::where('id', $id)->first();
        return view('accounts.bankDeposit', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\RequisitProduct;
use App\Models\TransactionReport;
use App\Models\OtherReceiveVoucher;
use App\Models\OtherPaymentVoucher;
use App\Models\BillCollection;
use App\Models\CustomerLedger;
use App\Models\EmployeeLedger;
use App\Models\HostelBillPayment;
use App\Models\Apartment\RentBillPayment;
use App\Models\Apartment\ApartmentBillPayment;
use App\Models\Restaurant\SupplierLedger;
use Validator;
use Session;
use DB;
include(app_path() . '/library/common.php');

class DailyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= TransactionReport::paginate(250);
        return view('accounts.dailyTransaction', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata'] = TransactionReport::whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            
            return view('accounts.dailyTransaction', $data);
        }
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
        //
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

    public function finalReport()
    {
        //$data['total_sell']= ProductSell::sum('grand_total');
        $data['supplier_payment']= SupplierLedger::where('reason', 'like', '%' . 'payment' . '%')->sum('amount');
        $data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive' . '%')->sum('amount');
        $data['other_payment']= OtherPaymentVoucher::sum('amount');
        $data['other_receive']= OtherReceiveVoucher::sum('amount');
        $data['employee_salary']= EmployeeLedger::where('reason', 'like', '%' . 'salary' . '%')->sum('amount');
        $data['bank_opening_balance']= TransactionReport::where('reason', 'like', '%' . 'Opening Balance' . '%')->sum('amount');
        $data['bank_deposit']= TransactionReport::where('reason', 'like', '%' . 'deposit' . '%')->sum('amount');
        $data['bank_withdraw']= TransactionReport::where('reason', 'like', '%' . 'withdraw' . '%')->sum('amount');
        $data['bank_transfer']= TransactionReport::where('reason', 'like', '%' . 'transfer' . '%')->sum('amount');
        //$data['food_sell']= TransactionReport::where('reason', 'like', '%' . 'food sell' . '%')->sum('amount');
        $data['hostel_bill_payment']= HostelBillPayment::sum('paid_amount');
        $data['apartment_bill_payment']= RentBillPayment::sum('paid_amount');
        $data['apartment_bill_payment_from_member']= ApartmentBillPayment::sum('paid_amount');
        $data['apartment_rent_advance']= TransactionReport::where('reason', 'like', '%' . 'Apartment Rent Advance' . '%')->sum('amount');
        return view('accounts.finalReport', $data);
    }

    public function finalReportFiltering(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            //$data['total_sell']= ProductSell::sum('grand_total');
            $data['supplier_payment']= SupplierLedger::where('reason', 'like', '%' . 'payment' . '%')->whereBetween('date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive' . '%')->whereBetween('date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['other_payment']= OtherPaymentVoucher::whereBetween('payment_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['other_receive']= OtherReceiveVoucher::whereBetween('receive_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['employee_salary']= EmployeeLedger::where('reason', 'like', '%' . 'salary' . '%')->whereBetween('date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['bank_opening_balance']= TransactionReport::where('reason', 'like', '%' . 'Opening Balance' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['bank_deposit']= TransactionReport::where('reason', 'like', '%' . 'deposit' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['bank_withdraw']= TransactionReport::where('reason', 'like', '%' . 'withdraw' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['bank_transfer']= TransactionReport::where('reason', 'like', '%' . 'transfer' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            //$data['food_sell']= TransactionReport::where('reason', 'like', '%' . 'food sell' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            $data['hostel_bill_payment']= HostelBillPayment::sum('paid_amount');
            $data['apartment_bill_payment']= RentBillPayment::sum('paid_amount');
            $data['apartment_bill_payment_from_member']= ApartmentBillPayment::sum('paid_amount');
            $data['apartment_rent_advance']= TransactionReport::where('reason', 'like', '%' . 'Apartment Rent Advance' . '%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->sum('amount');
            return view('accounts.finalReport', $data);
        }
    }

    public function overallIncomeReport()
    {
        //$data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Receive From%')->groupBy('keyword')->get();
        $data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Receive From%')->groupBy('keyword')->get();


        $datas = array();
        foreach($data['alldetails'] as $value){
            //$books[$value->id]['amount'] = $value->amount;
            $datas[$value->keyword] = [
                'keyword' => $value->keyword,
                'amount' => $value->ttl,
            ];
        }
        $data['alldata'] = $datas;

        return view('accounts.overall-income-report', $data);
    }

    public function overallIncomeReportFiltering(Request $request)
    {
        //$data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Receive From%')->groupBy('keyword')->get();
        $data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Receive From%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->groupBy('keyword')->get();


        $datas = array();
        foreach($data['alldetails'] as $value){
            //$books[$value->id]['amount'] = $value->amount;
            $datas[$value->keyword] = [
                'keyword' => $value->keyword,
                'amount' => $value->ttl,
            ];
        }
        $data['alldata'] = $datas;

        return view('accounts.overall-income-report', $data);
    }

    public function overallExpenseReport()
    {
        $data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Payment For%')->groupBy('keyword')->get();

        $datas = array();
        foreach($data['alldetails'] as $value){
            //$books[$value->id]['amount'] = $value->amount;
            $datas[$value->keyword] = [
                'keyword' => $value->keyword,
                'amount' => $value->ttl,
            ];
        }
        $data['alldata'] = $datas;

        return view('accounts.overall-expense-report', $data);
    }

    public function overallExpenseReportFiltering(Request $request)
    {
        $data['alldetails'] = TransactionReport::select('transation_report.*',DB::raw('SUM(amount) as ttl'))->where('keyword', 'LIKE', '%Payment For%')->whereBetween('transaction_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->groupBy('keyword')->get();

        $datas = array();
        foreach($data['alldetails'] as $value){
            //$books[$value->id]['amount'] = $value->amount;
            $datas[$value->keyword] = [
                'keyword' => $value->keyword,
                'amount' => $value->ttl,
            ];
        }
        $data['alldata'] = $datas;

        return view('accounts.overall-expense-report', $data);
    }
}

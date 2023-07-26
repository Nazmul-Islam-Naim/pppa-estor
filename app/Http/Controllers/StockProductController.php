<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use DataTables;
use Validator;
use Session;
use DB;

class StockProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('app.stock.report');
        if ($request->ajax()) {
            $alldata= StockProduct::with(['product','product.type','product.category','product.unit'])
                            ->where('status', '1')
                            ->orderBy('id', 'desc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('products.stock-product');
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

    //------------------------------- date wise stock product report ------------------//
    public function dateWiseStockReport(Request $request)
    {
        Gate::authorize('app.datewisestock.report');
        $data['alldata']= StockProductDetail::where([['reason', 'LIKE', '%'.'Add to Stock'.'%']])->groupBy('product_id')->select('stock_product_details.*')->get();
        
        $stocks = array();
        foreach($data['alldata'] as $value){
            $purchaseitem= StockProductDetail::where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->select('quantity')->count();
            $purchaseitemQnty= StockProductDetail::where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitem= StockProductDetail::where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->select('quantity')->count();
            $sellitemQnty= StockProductDetail::where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            
            // search date qnty
            $purchaseitemQnty2= StockProductDetail::where('date', '=', date('Y-m-d'))->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitemQnty2= StockProductDetail::where('date', '=', date('Y-m-d'))->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            
            // previous date qnty
            $purchaseitemQnty3= StockProductDetail::where('date', '<', date('Y-m-d'))->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitemQnty3= StockProductDetail::where('date', '<', date('Y-m-d'))->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            if($purchaseitem==0){
                $purchaseitemQntyVal=0;
            }else{
                $purchaseitemQntyVal=$purchaseitemQnty;
            }
            
            if($sellitem==0){
                $sellitemQntyVal=0;
            }else{
                $sellitemQntyVal=$sellitemQnty;
            }
            $stocks[$value['product_id']]['product_id'] = $value['product_id'];
            $stocks[$value['product_id']]['quantity'] = $purchaseitemQntyVal-$sellitemQntyVal;
            $stocks[$value['product_id']]['previous_qnty'] = $purchaseitemQnty3-$sellitemQnty3;
            $stocks[$value['product_id']]['purchase_qnty'] = $purchaseitemQnty2;
            $stocks[$value['product_id']]['sell_qnty'] = $sellitemQnty2;
            $stocks[$value['product_id']]['unit_price'] = $value['unit_price'];
        }
        $data['alldata']=$stocks;
        return view('products.date-wise-stock-report',$data);
    }
    //------------------------------- date wise stock product report filter------------------//
    public function dateWiseStockFilter(Request $request)
    {
        $data['alldata']= StockProductDetail::where([['reason', 'LIKE', '%'.'Add to Stock'.'%']])->groupBy('product_id')->select('stock_product_details.*')->get();
        
        $stocks = array();
        foreach($data['alldata'] as $value){
            $purchaseitem= StockProductDetail::where('date', '<=', $request->start_date)->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->select('quantity')->count();
            $purchaseitemQnty= StockProductDetail::where('date', '<=', $request->start_date)->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitem= StockProductDetail::where('date', '<=', $request->start_date)->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->select('quantity')->count();
            $sellitemQnty= StockProductDetail::where('date', '<=', $request->start_date)->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            
            // search date qnty
            $purchaseitemQnty2= StockProductDetail::where('date', '=', $request->start_date)->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitemQnty2= StockProductDetail::where('date', '=', $request->start_date)->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            
            // previous date qnty
            $purchaseitemQnty3= StockProductDetail::where('date', '<', $request->start_date)->where([['product_id',$value->product_id],['reason', 'LIKE', '%'.'Add to Stock'.'%']])->sum('quantity');
            $sellitemQnty3= StockProductDetail::where('date', '<', $request->start_date)->where([['reason', 'LIKE', '%'.'Sell'.'%'],['product_id', $value['product_id']]])->sum('quantity');
            if($purchaseitem==0){
                $purchaseitemQntyVal=0;
            }else{
                $purchaseitemQntyVal=$purchaseitemQnty;
            }
            
            if($sellitem==0){
                $sellitemQntyVal=0;
            }else{
                $sellitemQntyVal=$sellitemQnty;
            }
            $stocks[$value['product_id']]['product_id'] = $value['product_id'];
            $stocks[$value['product_id']]['quantity'] = $purchaseitemQntyVal-$sellitemQntyVal;
            $stocks[$value['product_id']]['previous_qnty'] = $purchaseitemQnty3-$sellitemQnty3;
            $stocks[$value['product_id']]['purchase_qnty'] = $purchaseitemQnty2;
            $stocks[$value['product_id']]['sell_qnty'] = $sellitemQnty2;
            $stocks[$value['product_id']]['unit_price'] = $value['unit_price'];
        }
        $data['alldata']=$stocks;
        $data['start_date'] = $request->start_date;
        //$data['end_date'] = $request->end_date;
        return view('products.date-wise-stock-report',$data);
    }
    
    
    // STOCK NOTIFY
    
    public function stockNotify(Request $request){
        Gate::authorize('app.stock.report');
        if ($request->ajax()) {
            $alldata = StockProduct::whereHas('product', function ($query) {
                $query->whereColumn('quantity', '<=', 'stock_notify');
            })
            ->with(['product','product.type','product.category','product.unit'])
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('products.stock-notify');
        

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vat;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class VatReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Vat::where('vat_percent', '!=', '0')->paginate(250);
        return view('vat.vatReport', $data);
    }

    public function reportFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= Vat::whereBetween('sell_date', [date('Y-m-d',strtotime($request->start_date)), date('Y-m-d',strtotime($request->end_date))])->where('vat_percent', '!=', '0')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('vat.vatReport', $data);
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
}

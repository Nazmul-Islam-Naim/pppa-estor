<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.productsubcategory.index');
        $data['allcategory']= ProductCategory::where('status', 1)->get();
        $data['alldata']= ProductSubCategory::where('status', 1)->get();
        return view('products.product-sub-category', $data);
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
        Gate::authorize('app.productsubcategory.create');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['product_category_id'] = decrypt($request->product_category_id);
        $input['status'] = 1;
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= ProductSubCategory::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Product Sub Category Successfully Added !');
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
        Gate::authorize('app.productsubcategory.edit');
        $data['allcategory']= ProductCategory::where('status', 1)->get();
        $data['alldata']= ProductSubCategory::where('status', 1)->get();
        $data['single_data']= ProductSubCategory::findOrFail(decrypt($id));
        return view('products.product-sub-category', $data);
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
        Gate::authorize('app.productsubcategory.edit');
        $data=ProductSubCategory::findOrFail(decrypt($id));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        $input['product_category_id'] = decrypt($request->product_category_id);
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
            Session::flash('flash_message','Product Sub Category Successfully Updated !');
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
        Gate::authorize('app.productsubcategory.destroy');
        $data = ProductSubCategory::findOrFail(decrypt($id));
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Product Sub Category Successfully Deleted !');
            return redirect()->route('product-sub-category.index')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('product-sub-category.index')->with('status_color','danger');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ProductType;
use App\Models\ProductUnit;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Product;
use DataTables;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        Gate::authorize('app.product.index');
        if ($request->ajax()) {
            $alldata= Product::with(['type','category','subcategory','unit','brand'])
                            ->where('status', '1')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>

                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('product.edit', encrypt($row->id)); ?>" class="badge bg-primary badge-sm" data-id="<?php echo encrypt($row->id); ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo encrypt($row->id); ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('products.product-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.product.create');
        $data['alldata']= Product::where('status', 1)->get();
        $data['alltype']= ProductType::where('status', 1)->get();
        $data['allunit']= ProductUnit::where('status', 1)->get();
        $data['allbrand']= ProductBrand::where('status', 1)->get();
        $data['allcategory']= ProductCategory::where('status', 1)->get();
        $data['allsubcategory']= ProductSubCategory::where('status', 1)->get();
        return view('products.product', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.product.create');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'product_type_id' => 'required',
            'product_category_id' => 'required',
            'product_sub_category_id' => 'required',
            'product_unit_id' => 'required',
            'product_brand_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['product_type_id'] = decrypt($request->product_type_id);
        $input['product_category_id'] = decrypt($request->product_category_id);
        $input['product_unit_id'] = decrypt($request->product_unit_id);
        $input['product_brand_id'] = decrypt($request->product_brand_id);
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= Product::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Product Successfully Added !');
            return redirect()->route('product.index')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('product.index')->with('status_color','danger');
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
        Gate::authorize('app.product.edit');
        $data['alldata']= Product::where('status', 1)->get();
        $data['single_data']= Product::findOrFail(decrypt($id));
        $data['alltype']= ProductType::where('status', 1)->get();
        $data['allunit']= ProductUnit::where('status', 1)->get();
        $data['allbrand']= ProductBrand::where('status', 1)->get();
        $data['allcategory']= ProductCategory::where('status', 1)->get();
        $data['allsubcategory']= ProductSubCategory::where('status', 1)->get();
        return view('products.product', $data);
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
        Gate::authorize('app.product.edit');
        $data=Product::findOrFail(decrypt($id));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'product_type_id' => 'required',
            'product_category_id' => 'required',
            'product_sub_category_id' => 'required',
            'product_unit_id' => 'required',
            'product_brand_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        $input['product_type_id'] = decrypt($request->product_type_id);
        $input['product_category_id'] = decrypt($request->product_category_id);
        $input['product_unit_id'] = decrypt($request->product_unit_id);
        $input['product_brand_id'] = decrypt($request->product_brand_id);
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
            Session::flash('flash_message','Product Successfully Updated !');
            return redirect()->route('product.index')->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('product.index')->with('status_color','danger');
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
        Gate::authorize('app.product.destroy');
        $data = Product::findOrFail(decrypt($id));
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Product Successfully Deleted !');
            return redirect()->route('product.index')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('product.index')->with('status_color','danger');
        }
    }
}

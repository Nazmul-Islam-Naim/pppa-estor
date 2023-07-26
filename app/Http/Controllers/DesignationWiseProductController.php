<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\DesignationWiseProduct;
use App\Models\DesignationWiseProductDetail;
use DataTables;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class DesignationWiseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('app.productassign.report');
        if ($request->ajax()) {
            $alldata= DesignationWiseProduct::with(['designation','creator'])
                            ->where('status', '1')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('user.designation-wise-product-report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.productassign.index');
        $data['alldesignation'] = Designation::all();
        $data['allproduct'] = Product::where('product_type_id',2)->get();
        return view('user.designation-wise-product-form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.productassign.index');
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= DesignationWiseProduct::create($input);
            //--------------------- designaiton wise product details ----------------//
            foreach ($request->addmore as $value) {
                DesignationWiseProductDetail::create([
                    'designation_id' => $input['designation_id'],
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'product_type_id' => $value['product_type_id'],
                    'tok' => $input['tok'],
                    'date' => $input['date'],
                    'status' =>  $input['status'],
                    'created_by' => $input['created_by']
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Product Added To Designation !');
            return redirect()->route('designation-wise-product.index')->with('status_color','success');
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
        Gate::authorize('app.productassign.amendment');
        $data['single_data'] = DesignationWiseProduct::where('id',$id)->first();
        $data['alldata'] = DesignationWiseProductDetail::where('tok',$data['single_data']->tok)->get();
        $data['alldesignation'] = Designation::all();
        $data['allproduct'] = Product::where('product_type_id',2)->get();
        return view('user.designation-wise-product-edit-form',$data);
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
        Gate::authorize('app.productassign.amendment');
        $data=DesignationWiseProduct::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'designation_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;
            //----------------------------- delete details ----------------//
            $deletedetails = DesignationWiseProductDetail::where('tok',$data->tok)->delete();
            //----------------------------- update -----------------//
            $insert= $data->update($input);
            //--------------------- designation wise product details ----------------//
            foreach ($request->addmore as $value) {
                DesignationWiseProductDetail::create([
                    'designation_id' => $input['designation_id'],
                    'product_id' => $value['product_id'],
                    'product_type_id' => $value['product_type_id'],
                    'quantity' => $value['quantity'],
                    'tok' => $data->tok,
                    'date' => $input['date'],
                    'status' =>  $input['status'],
                    'created_by' => $input['created_by']
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Product Updated To Designation !');
            return redirect()->route('designation-wise-product.index')->with('status_color','success');
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
        Gate::authorize('app.productassign.amendment');
        $data = DesignationWiseProduct::findOrFail($id);
        $deletedetails = DesignationWiseProductDetail::where('tok',$data->tok)->delete();
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Designation Product Deleted !');
            return redirect()->route('designation-wise-product.index')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('designation-wise-product.index')->with('status_color','danger');
        }
    }

    //-------------------------- show user wise product amendment -----------------//
    public function designationWiseProductAmendment(Request $request)
    {
        Gate::authorize('app.productassign.amendment');
        if ($request->ajax()) {
            $alldata= DesignationWiseProduct::with(['designation','creator'])
                            ->where('status', '1')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('designation-wise-product.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('user.designation-wise-product-amendment');
    }
    //-------------------------- show desigantion wise product details -----------------//
    public function designationWiseProductDetails(Request $request,$tok)
    {
        Gate::authorize('app.productassign.report');
        $data['single_data'] = DesignationWiseProduct::where('tok',$tok)->first();
        $data['alldata'] = DesignationWiseProductDetail::where('tok',$tok)->get();
        return view('user.designation-wise-product-report-details',$data);
    }
}

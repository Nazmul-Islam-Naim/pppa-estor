<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Asset;
use App\Models\Product;
use App\Models\AssetType;
use App\Models\AssetSubType;
use App\Models\DesignationWiseAsset;
use App\Models\DesignationWiseAssetDetail;
use DataTables;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class DesignationWiseAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('app.assignasset.report');
        if ($request->ajax()) {
            $alldata= DesignationWiseAsset::with(['designation','creator'])
                            ->where('status', '1')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('asset.designation-wise-asset-report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.assignasset.index');
        $data['alldesignation'] = Designation::all();
        $data['allasset'] = Product::where('product_type_id',1)->get();
        return view('asset.designation-wise-asset-form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.assignasset.index');
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
        $input['date'] = date('Y-m-d',strtotime($request->date));

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= DesignationWiseAsset::create($input);
            //--------------------- desigantion wise asset details ----------------//
            foreach ($request->addmore as $value) {
                DesignationWiseAssetDetail::create([
                    'designation_id' => $input['designation_id'],
                    'asset_id' => $value['asset_id'],
                    'quantity' => $value['quantity'],
                    'max_limit' => $value['max_limit'],
                    'des' => $value['des'],
                    'tok' => $input['tok'],
                    'date' =>  date('Y-m-d',strtotime($input['date'])),
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
            Session::flash('flash_message','Asset Added To Designation !');
            return redirect()->route('assign-asset.index')->with('status_color','success');
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
        Gate::authorize('app.assignasset.amendment');
        $data['single_data'] = DesignationWiseAsset::where('id',$id)->first();
        $data['alldata'] = DesignationWiseAssetDetail::where('tok',$data['single_data']->tok)->get();
        $data['alldesignation'] = Designation::all();
        $data['allasset'] = Product::where('product_type_id',1)->get();
        return view('asset.designation-wise-asset-edit-form',$data);
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
        Gate::authorize('app.assignasset.amendment');
        $data=DesignationWiseAsset::findOrFail($id);

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
            $deletedetails = DesignationWiseAssetDetail::where('tok',$data->tok)->delete();
            //----------------------------- update -----------------//
            $insert= $data->update($input);
            //--------------------- designation wise asset details ----------------//
            foreach ($request->addmore as $value) {
                DesignationWiseAssetDetail::create([
                    'designation_id' => $input['designation_id'],
                    'asset_id' => $value['asset_id'],
                    'quantity' => $value['quantity'],
                    'max_limit' => $value['max_limit'],
                    'des' => $value['des'],
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
            Session::flash('flash_message','Asset Updated To Designation !');
            return redirect()->route('assign-asset.index')->with('status_color','success');
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
        Gate::authorize('app.assignasset.amendment');
        $data = DesignationWiseAsset::findOrFail($id);
        $deletedetails = DesignationWiseAssetDetail::where('tok',$data->tok)->delete();
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Designation Asset Deleted !');
            return redirect()->route('assign-asset.index')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->route('assign-asset.index')->with('status_color','danger');
        }
    }

    //-------------------------- show designation wise asset amendment -----------------//
    public function designationWiseAssetAmendment(Request $request)
    {
        Gate::authorize('app.assignasset.amendment');
        if ($request->ajax()) {
            $alldata= DesignationWiseAsset::with(['designation','creator'])
                            ->where('status', '1')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('assign-asset.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('asset.designation-wise-asset-amendment');
    }
    //-------------------------- show desigantion wise asset details -----------------//
    public function designationWiseAssetDetails(Request $request,$tok)
    {
        Gate::authorize('app.assignasset.report');
        $data['single_data'] = DesignationWiseAsset::where('tok',$tok)->first();
        $data['alldata'] = DesignationWiseAssetDetail::where('tok',$tok)->get();
        return view('asset.designation-wise-asset-report-details',$data);
    }

    //------------------------------ ajax part unused----------------------//
    public function getAssetType(Request $request)
    {
        $assetid = Asset::where('id',$request->id)->first();
        $data['type'] = AssetType::where('id', $assetid->asset_type_id)->first();
        $data['subtype'] = AssetSubType::where('id',$assetid->asset_sub_type_id)->first();
        return Response::json($data);
        die;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\AssetSubType;
use App\Models\AssetType;
use App\Models\Asset;
use DataTables;
use Validator;
use Response;
use Session;
use Image;
use Auth;
use Hash;
use DB;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('app.asset.index');
        $data['alltype']= AssetType::all();
        $data['allsubtype']= AssetSubType::all();
        if ($request->ajax()) {
            $alldata= Asset::with(['assettype','assetsubtype'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>

                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('asset.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('asset.asset', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.asset.create');
        $data['alltype']= AssetType::all();
        $data['allsubtype']= AssetSubType::all();
        return view('asset.books-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.asset.create');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required | numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
        
        // books image
        if ($request->hasFile('image')) {
            $photo=$request->file('image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            Image::make($photo)->resize(144,144)->save(public_path('upload/books/'.$fileName));
            $input['image']=$fileName;
        }

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= Asset::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Asset Successfully Added !');
            return redirect()->route('asset.index')->with('status_color','success');
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
    public function edit(Request $request, $id)
    {
        Gate::authorize('app.asset.edit');
        $data['single_data']= Asset::findOrFail($id);
        $data['alltype']= AssetType::all();
        $data['allsubtype']= AssetSubType::all();
        return view('asset.books-form', $data);
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
        Gate::authorize('app.asset.edit');
        $data=Asset::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required | numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
         // books image
        if ($request->hasFile('image')) {
            $photo=$request->file('image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            Image::make($photo)->resize(144,144)->save(public_path('upload/books/'.$fileName));
            $input['image']=$fileName;
        }
        
        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Asset Successfully Updated !');
            return redirect()->route('asset.index')->with('status_color','warning');
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
        Gate::authorize('app.asset.destroy');
        $data = Asset::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Asset Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    //--------------------------- ajax ------------------------//
    public function getSubType(Request $request)
    {
        $subtype = AssetSubType::select('name', 'id')->where('asset_type_id',$request->id)->get();
        return Response::json($subtype);
        die;
    }
}

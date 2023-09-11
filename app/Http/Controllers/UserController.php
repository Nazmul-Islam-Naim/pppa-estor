<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DesignationWiseAssetDetail;
use App\Models\DesignationWiseProductDetail;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use App\Models\UserWiseAssetDetail;
use App\Models\UserWiseProductDetail;
use App\Models\Requisition;
use Validator;
use Response;
use Session;
use Image;
use Auth;
use Hash;
use DB;
use DataTables;
use Illuminate\Support\Facades\Gate;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('app.users.index');
        if ($request->ajax()) {
            $alldata= User::with(['department','designation','role'])
                            ->where('id', '!=', 1)
                            ->where('status', 1)
                            ->orderBy('designation_id','asc')
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('user-list.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.users.create');
        $data['roles']= Role::all();
        $data['designations']= Designation::all();
        $data['departments']= Department::all();
        return view('user.add-user', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('app.users.create');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role_id'=>'required|integer',
            'department_id'=>'required|integer',
            'designation_id'=>'required|integer',
            'email' => 'required|email|unique:users|max:191',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['password_hint'] = $request->password;

        // user image
        if ($request->hasFile('image')) {
            $photo=$request->file('image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            Image::make($photo)->resize(144,144)->save(public_path('upload/user/'.$fileName));
            $input['image']=$fileName;
        }

        try{
            $insert = User::create($input);
            Session::flash('flash_message','User Successfully Added !');
            return redirect()->route('user-list.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Faild to create user!');
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
        
        $data['userinfo'] = User::findOrFail($id);
        $data['userasset'] = DesignationWiseAssetDetail::where('designation_id', $data['userinfo']->designation_id)->get();
        $data['userproduct'] = DesignationWiseProductDetail::where([['designation_id',$data['userinfo']->designation_id],['product_type_id',2]])->paginate(11);
        $data['userrole'] = User::findOrFail($id);
        $data['userrequsition'] = Requisition::checkUser($data['userinfo'])->confirmed()->orderBy('id','desc')->get();
        $data['userrequsitiondetails'] = Requisition::checkUser($data['userinfo'])->confirmed()->orderBy('id','desc')->get();
        return view('user.user-profile',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('app.users.edit');
        $data['roles']= Role::all();
        $data['designations']= Designation::all();
        $data['departments']= Department::all();
        $data['single_data']=User::findOrFail($id);
        return view('user.add-user', $data);
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
        Gate::authorize('app.users.edit');
        $data=User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role_id'=>'required|integer',
            'department_id'=>'required|integer',
            'designation_id'=>'required|integer',
            'email' => 'required|unique:users,email,'.$data->id
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        // user image
        if ($request->hasFile('image')) {
            $photo=$request->file('image');
            $fileType=$photo->getClientOriginalExtension();
            // dd($fileType);
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            Image::make($photo)->resize(144,144)->save(public_path('upload/user/'.$fileName));
            $input['image']=$fileName;
        }
            
        if ($request->password !="") {
            $input['password'] = Hash::make($request->password);
            $input['password_hint'] = $request->password;
        }else{
            $input['password'] = $data->password;
        }

        try{
            $data->update($input);
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect()->route('user-list.index')->with('status_color','warning');
        }catch(\Exception $e){
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
        Gate::authorize('app.users.destroy');
        User::where('id', $id)->update(['status' => 0]);
        Session::flash('flash_message','User Successfully Updated !');
        return redirect()->back()->with('status_color','warning');
    }

    // user list by yarja data table

}

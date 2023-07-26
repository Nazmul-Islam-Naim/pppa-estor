<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\AccountType;
use App\Models\DamageRequest;
use App\Models\DamageRequestProduct;
use App\Models\DesignationWiseAssetDetail;
use App\Models\DesignationWiseProduct;
use App\Models\Requisition;
use App\Models\RequisitonProduct;
use App\Models\UserWiseProductDetail;
use App\Models\Product;
use App\Models\StockProductDetail;
use App\Models\UserWiseAssetDetail;
use App\Models\UserWiseProduct;
use Carbon\Carbon;
use DataTables;
use Validator;
use Response;
use Session;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth ;

class DamageRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Gate::authorize('app.accounttype.index');
        if ($request->ajax()) {
            $alldata= DamageRequest::authorized()->pending()->with(['user','user.department','user.designation','user.role'])
                            ->get();     
                              
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                <ul class="list-inline m-0">
                    <!-- <li class="list-inline-item">
                        <a href="<?php echo route('requisition.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li> -->
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('damage.request_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['allasset'] = DesignationWiseAssetDetail::where('designation_id',Auth::user()->designation->id)->get();
        // $data['allproduct'] = UserWiseProductDetail::join('user_wise_asset_details','user_wise_product_details.user_id','user_wise_asset_details.user_id')
        //                                             ->where('user_wise_product_details.user_id',Auth::id())
        //                                             ->select('user_wise_product_details.*','user_wise_asset_details.*')
        //                                             ->get();
        // dd($data);
        return view('damage.request-form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Gate::authorize('app.accounttype.create');
        // dd($request->all());
        $request->validate([
            'date'=>'required',
            'note'=>'nullable|string',
        ]);

        DB::beginTransaction();

        // try{
            $damageRequest = DamageRequest::create([
                "date"=>$request->date,
                "user_id"=>Auth::user()->id,
                "username"=>Auth::user()->name,
                "note"=>$request->note,
            ]);
            //--------------------- FRequisitions details ----------------//
            foreach ($request->addmore as $value) {
                $asset_details = DesignationWiseAssetDetail::checkUser()->checkAsset($value['product_id'])->first();
                // dd($asset_details->quantity , $value['quantity'], $asset_details->quantity < $value['quantity']);
                if($asset_details->quantity < $value['quantity']){
                    Session::flash('flash_message',$asset_details->asset->name . ' doesnt has qunatity '.$value['quantity'] );
                    return redirect()->back()->with('status_color','danger');
                }
                $damageRequest->damageRequestProducts()->create([
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity']
                ]);
            }
            DB::commit();
            Session::flash('flash_message','Damage request Created and waiting for approval');
            return redirect()->route('damagerequests.show', $damageRequest->id)->with('status_color','success');
        // }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
            DB::rollback();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['single_data'] = DamageRequest::authorized()->findOrFail($id);
        $data['alldata'] = DamageRequestProduct::where('damage_request_id',$id)->get();
        $data['user']=Auth::user();
        return view('damage.damage-invoice',$data);
    }


    public function statusupdate(Request $request, $id)
    { 
        $request->validate([
            'status'=>"required|in:".implode(',',Status::getCases()),
        ]);

        try{
            $user = Auth::user();
            $damagerequest = DamageRequest::authorized()->findOrfail($id);
            
            $status = Status::getFromName($request->status);

            $updateto = $damagerequest->status;
            if($status->toString() == "Approver" && $damagerequest->can($status,$user)){
                //stock
                $tok = date('Ymdhis');
                foreach($damagerequest->damageRequestProducts as $requestProduct){
                    $designationwiseproduct = DesignationWiseAssetDetail::checkUser($damagerequest->user)->checkAsset($requestProduct->product_id)->first();
                    // if(($designationwiseproduct->quantity+$requestProduct->quantity)>$designationwiseproduct->max_limit){
                    //     Session::flash('flash_message',$designationwiseproduct->asset->name.' maxlimit exeeded');
                    //     return redirect()->back()->with('status_color','danger');
                    // }

                    $designationwiseproduct->update([
                        'quantity' => $designationwiseproduct->quantity-$requestProduct->quantity
                    ]); 

                    $requestProduct->update([
                        'adjusted'=>now()
                    ]);
                }
                

                $updateto = $status->value;
            }
            else if($damagerequest->can($status,$user)){
                $updateto = $status->value;
            }
      
            $damagerequest->update([
                'status'=>$updateto
            ]);

            Session::flash('flash_message','Damage request '.$status->toType());
            return redirect()->route('damagerequests.index')->with('status_color','success');
        }catch(Exception $exception){
            Session::flash('flash_message',$exception->getMessage());
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function report(Request $request)
    {
        if ($request->ajax()) {
            $alldata= DamageRequestProduct::checkDate()->with('damageRequest.user.designation','product.category')->get();
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view ('damage.report');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Gate::authorize('app.accounttype.edit');
        $data['allasset'] = DesignationWiseAssetDetail::where('designation_id',Auth::user()->designation->id)->get();
        // dd($data);
        return view('requisition.requisition-edit-form',$data);
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
        // Gate::authorize('app.accounttype.edit');
        $data=Requisition::findOrFail($id);

        
        $request->validate([
            'date'=>'required',
            'note'=>'nullable|string',
        ]);

        DB::beginTransaction();

        try{
            //------------------------- delete Requisition details -------------------//
            $deletedetails = RequisitonProduct::where('requisition_id',$id)->delete();
            //------------------------- update Requisition details -------------------//
            $requisition = $data->update([
                "date"=>$request->date,
                "note"=>$request->note,
            ]);
            //--------------------- FRequisitions details ----------------//
            foreach ($request->addmore as $value) {
                $data->requisitionProducts()->create([
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity']
                ]);
            }
            DB::commit();
            Session::flash('flash_message','Requisition Updated and waiting for approval');
            return redirect()->back()->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
            DB::rollback();
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
        // Gate::authorize('app.accounttype.destroy');
        $data = DamageRequest::authorized()->findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Damage Request Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

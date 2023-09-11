<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Exceptions\QuantityException;
use App\Models\RequisitionComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\AccountType;
use App\Models\DesignationWiseAsset;
use App\Models\DesignationWiseAssetDetail;
use App\Models\DesignationWiseProduct;
use App\Models\DesignationWiseProductDetail;
use App\Models\Requisition;
use App\Models\RequisitonProduct;
use App\Models\UserWiseProductDetail;
use App\Models\Product;
use App\Models\StockProductDetail;
use App\Models\UserWiseAssetDetail;
use App\Notifications\RequsitionNotifiation;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use DataTables;
use Validator;
use Response;
use Session;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth ;

class RequisitionController extends Controller
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
            
            $alldata= Requisition::authorized()->pending()->with(['user','user.department','user.designation','user.role'])
                            ->get();             
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('requisition.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('requisition.requisition-list');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptedRequisition(Request $request)
    {
        Gate::authorize('app.requisition.report');
        if ($request->ajax()) {
            
            $alldata= Requisition::with(['user','user.department','user.designation','user.role'])
                            ->where('status', 3)
                            ->orWhere('status', 4)
                            ->get();             
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view('requisition.requisition-accept-list');
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['allproduct'] = DesignationWiseProductDetail::where('designation_id',Auth::user()->designation->id)->get();
        $data['allasset'] = DesignationWiseAssetDetail::where('designation_id',Auth::user()->designation->id)->get();
        // $data['allproduct'] = UserWiseProductDetail::join('user_wise_asset_details','user_wise_product_details.user_id','user_wise_asset_details.user_id')
        //                                             ->where('user_wise_product_details.user_id',Auth::id())
        //                                             ->select('user_wise_product_details.*','user_wise_asset_details.*')
        //                                             ->get();
        // dd($data);
        return view('requisition.requisition-form',$data);
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
        $request->validate([
            'date'=>'required',
            'note'=>'nullable|string',
        ]);

        DB::beginTransaction();

        // try{
            $requisition = Requisition::create([
                "date"=>$request->date,
                "user_id"=>Auth::user()->id,
                "username"=>Auth::user()->name,
                "note"=>$request->note,
            ]);
            //--------------------- FRequisitions details ----------------//
            foreach ($request->addmore as $value) {
                $product = Product::findOrFail($value['product_id']);
                if($product->product_type_id !=1){
                    $requsitionProducts = RequisitonProduct::getProductsQuery(Auth::user()->id,$value['product_id'],Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth())->get();
                    if($requsitionProducts->count()){
                        $sum = $requsitionProducts->sum('quantity');
                        $userWiseProduct =  DesignationWiseProduct::where('designation_id',Auth::user()->designation->id)->where('product_id',$value['product_id'])->first();
                        if($userWiseProduct->quantity <= $sum || $userWiseProduct->quantity < $sum+$value['quantity']){
                            Session::flash('flash_message',$userWiseProduct->product->name.' limit exeeded!');
                            return redirect()->back()->with('status_color','danger');
                        }
                    }
                }
                else{
                    $designationwiseAsset = DesignationWiseAssetDetail::checkUser(Auth::user())->checkAsset($product->id)->first();
                    if(($designationwiseAsset->quantity+$value['quantity'])>$designationwiseAsset->max_limit){
                        Session::flash('flash_message',$designationwiseAsset->asset->name.' maxlimit exeeded');
                        return redirect()->back()->with('status_color','danger');
                    }
                }
                $requisition->requisitionProducts()->create([
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity']
                ]);
            }
            DB::commit();
            Session::flash('flash_message','Requisition Created and waiting for approval');
            return redirect()->route('requisition.show',$requisition->id)->with('status_color','success');
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
        $data['single_data'] = Requisition::authorized()->findOrFail($id);
        $data['alldata'] = RequisitonProduct::where('requisition_id',$id)->get();
        $data['user']=Auth::user();
        return view('requisition.requisition-invoice',$data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completeInvoice(Request $request, $id)
    {
        $data['single_data'] = Requisition::findOrFail($id);
        $data['alldata'] = RequisitonProduct::where('requisition_id',$id)->get();
        $data['user']=Auth::user();
        return view('requisition.complete-invoice',$data);
    }


    public function statusupdate(Request $request, $id)
    {
        $request->validate([
            'status'=>"required|in:".implode(',',Status::getCases()),
            'message'=>'required_if:status,Pending'
        ]);

        try{
            $user = Auth::user();
            $requisition = Requisition::findOrfail($id);
            
            $status = Status::getFromName($request->status);

            $updateto = $requisition->status;

            if($status->toString() == "Confirmed" && $requisition->can($status,$user)){
                // dd($request->all());
                //stock
                $tok = date('Ymdhis');
                foreach($requisition->requisitionProducts as $requisitionProduct){
                    $requisitionProduct->product->stockProduct->update([
                        'quantity'=> $requisitionProduct->product->stockProduct->quantity -= $requisitionProduct->quantity
                    ]);

                    StockProductDetail::create([
                        'date'=>now(),
                        'product_id'=>$requisitionProduct->product->id,
                        'quantity'=>$requisitionProduct->quantity,
                        'unit_price'=>$requisitionProduct->product->stockProduct->unit_price,
                        'reason'=>'Sell',
                        'tok'=>$tok,
                        'status'=>'1'
                    ]);

                    $requisitionProduct->update([
                        'adjusted'=>now()
                    ]);
                }

                if( $requisitionProduct->product->product_type_id == 1){
                    $designationwiseAsset = DesignationWiseAssetDetail::checkUser($requisitionProduct->user)->checkAsset($requisitionProduct->product->id)->first();
                    $designationwiseAsset->update([
                        'quantity' => $designationwiseAsset->quantity+$requisitionProduct->quantity
                    ]);
                }
                

                $updateto = $status->value;
            }
            else if($requisition->can($status,$user)){
                $updateto = $status->value;
                // if($request->status =='Published'){
                //     Notification::send($admins,new RequsitionNotifiation($requisition));
                // }
            }
      
            $requisition->update([
                'status'=>$updateto
            ]);

            $comment = $status->toComment();
            $comment_status = true;

            if($request->status == 'Pending'){
                $comment = $request->message;
                $comment_status = false;
            }

            $test = RequisitionComment::create([
                'requisition_id' => $requisition->id,
                'user_id' => $user->id,
                'comment'=>$comment,
                'status'=>$comment_status,
                'type'=>$status->toType()
            ]);
            // dd($test);
            Session::flash('flash_message','Requisition '.$status->toType());
            return redirect()->route('requisition.index')->with('status_color','success');
        }catch(Exception $exception){
            if($exception instanceof QuantityException ){
                Session::flash('flash_message',$exception->getMessage());
            }else{
                Session::flash('flash_message','Something went wrong');
            }
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function report(Request $request)
    {  
        if ($request->ajax()) {
            $alldata= RequisitonProduct::checkDate()->with('requisition.user.designation','product.category')->get();             
            return DataTables::of($alldata)
            ->addIndexColumn()->make(True);
        }
        return view ('requisition.report');
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
        $data['single_data']= Requisition::authorized()->findOrFail($id);
        $data['alldata']= RequisitonProduct::where('requisition_id',$data['single_data']->id)->get();
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
        $data=Requisition::authorized()->findOrFail($id);

        
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
            return redirect()->route('requisition.show',$data->id)->with('status_color','success');
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
        $data = Requisition::authorized()->findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Requisition Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    // destryo a product
    
    public function deleteAnItem($id){
        $data = RequisitonProduct::findOrFail(decrypt($id));
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Product Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

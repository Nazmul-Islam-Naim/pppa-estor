<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\DesignationWiseAssetDetail;
use Illuminate\Http\Request;
use App\Models\StockProduct;
use App\Models\Requisition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\UserWiseAssetDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Asset;
use Session;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['product'] = Product::get();
        
        $data['stockNotify'] = StockProduct::whereHas('product', function ($query) {
            $query->whereColumn('quantity', '<=', 'stock_notify');
        })->count();
        $data['department'] = Department::count();
        $data['designation'] = Designation::count();
        $data['stock'] = StockProduct::sum('quantity');
        $data['product'] = Product::count();
        $data['asset'] = DesignationWiseAssetDetail::sum('quantity');
        $data['user'] = User::count();
        $data['pendingrequisition'] = Requisition::authorized()->where('status',Status::Published->value)->orWhere('status',Status::Approver->value)->count();
        $data['books'] = Asset::sum('quantity');
        return view('user-home',$data);
    }

    // stock product chart
    public function stockProduct(){
        $out = 1 ;
        $low = 1 ;
        $ok = 1 ;
        $alldata = ['ok'=>0,'low'=>0,'out'=>0];
        $data = StockProduct::with('product')->get();
        foreach ($data as $key => $value) {
           if ($value->quantity > $value->product->stock_notify) {
            $alldata['ok'] = $ok++;
           } else if (($value->quantity > 0) && ($value->quantity <= $value->product->stock_notify)) {
            $alldata['low'] = $low++;
           }else{
            $alldata['out'] = $out++;
           }
        }
        return $alldata;
    }
    public function selectBranch()
    {
        return view('branchPanelPopup');
    }

    public function adminSelectedDashboard($branch_id)
    {
        if(Auth::user()->user_type == 1)
        {
            session(['branch_id' => $branch_id]);
            return redirect('user-home');
        }
    }
}

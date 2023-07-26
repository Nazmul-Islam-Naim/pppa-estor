<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Currency;
use App\Models\User;
use App\Models\ThemeSetting;
use Validator;
use Response;
use Session;
use Auth;
use Hash;
use DB;

class SettingController extends Controller
{
    public function index()
    {
        return view('user.setting');
    }

    public function saveSiteSetting(Request $request, $id)
    {
        $data=SiteSetting::findOrFail($id);
        $input = $request->all();
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
            Session::flash('flash_message','Data Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function saveCurrencySetting(Request $request, $id)
    {
        $data=Currency::findOrFail($id);
        $input = $request->all();
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
            Session::flash('flash_message','Data Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function updateUserPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $data=User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['password_hint'] = $request->password;
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
            Session::flash('flash_message','Password Changed.');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function saveSiteTheme(Request $request, $id)
    {
        $data=ThemeSetting::where('user_id', $id)->first();
        $input = $request->all();
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
            Session::flash('flash_message','Data Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

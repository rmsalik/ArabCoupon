<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function index(Request $request){
        //echo Hash::make('admin123!');exit;
        if($request->isMethod('POST')){
            $isExits = Admin::where(['username' => $request->username])->first();
            if($isExits==null)
                return redirect()->back()->with('error','Invalid username/email');
            else {
                if(Hash::check($request->password, $isExits['password'])) {
                    session(['adminSet' => $isExits]);
                    return redirect()->route('category-crud.index');
                }else{
                    return redirect()->back()->with('error','Invalid password');
                }
            }
        }
        return view('admin.login')/*->with(compact('data'))*/;
    }

    function logout(Request $request){
        $request->session()->forget(['adminSet']);
        return redirect('admin/login');
    }

    function password(Request $request){
        if($request->isMethod('POST')) {
            $password = $request->input('password');
            $cPassword = $request->input('cPassword');
            if($password === $cPassword){
                Admin::where('id',session('adminSet.id'))->update(['password'=>$this->passEncode($cPassword)]);
                return redirect()->back()->with('success', 'Your password has been updated successfully');
            }else{
                return redirect()->back()->with('error', 'Your password should match with confirm password.');
            }
        }
        return view('admin.password');
    }

    private function passEncode($pass){
        return Hash::make($pass);
    }
}

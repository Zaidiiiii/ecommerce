<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
        return view('admin.login');
    }

  
  
    public function auth(Request $req)
    {
        //
        $email=$req->post('email');
        $password=$req->post('password');

        //$result=Admin::where(['email'=>$email,'password'=>$password])->get();
        $result=Admin::where(['email'=>$email])->first();
        if($result){
            if(Hash::check($req->post('password'),$result->password)){
                $req->session()->put('ADMIN_LOGIN',true);
                $req->session()->put('ADMIN_ID',$result->id);
                return redirect('/admin/dashboard');
            }else{
                $req->session()->flash('error','Please enter correct password');
            return redirect('/admin/login');
            }
            
        }else{
            $req->session()->flash('error','Please enter valid login');
            return redirect('/admin/login');
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

 
}
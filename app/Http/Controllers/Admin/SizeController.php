<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Size::all();
        return view('admin.size',$result);
    }

    
    public function manage_size(Request $req,$id='')
    {
        if($id>0){
            $arr=Size::where(['id'=>$id])->get();

            $result['size']=$arr['0']->size;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['size']='';
            $result['status']='';
            $result['id']='0';
        }
        return view('admin/manage_size',$result);
    }

    public function manage_size_process(Request $req)
    {
        $req->validate([
            'size'=>'required|unique:sizes,size,'.$req->post('id'),
        ]);

        if($req->post('id')>0){
            $model=Size::find($req->post('id'));
            $msg="Size updated";
        }else{
            $model=new Size();
            $msg="Size inserted";
        }

        $model->size=$req->post('size');
        $model->status=1;
        $model->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/size');
    }

    public function delete(Request $req,$id)
    {
        $model=Size::find($id);
        $model->delete();
        $req->session()->flash('message','Size Deleted');
        return redirect('/admin/size');
    }

    public function status(Request $req, $status,$id)
    {
        $model=Size::find($id);
        $model->status=$status;
        $model->save();
        $req->session()->flash('message','Size Satatus Updated');
        return redirect('/admin/size');
    }
}
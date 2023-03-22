<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Color::all();
        return view('admin.color',$result);
    }

    
    public function manage_color(Request $req,$id='')
    {
        if($id>0){
            $arr=Color::where(['id'=>$id])->get();

            $result['color']=$arr['0']->color;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['color']='';
            $result['status']='';
            $result['id']='0';
        }
        return view('admin/manage_color',$result);
    }

    public function manage_color_process(Request $req)
    {
        $req->validate([
            'color'=>'required|unique:colors,color,'.$req->post('id'),
        ]);

        if($req->post('id')>0){
            $model=Color::find($req->post('id'));
            $msg="Color updated";
        }else{
            $model=new Color();
            $msg="Color inserted";
        }

        $model->color=$req->post('color');
        $model->status=1;
        $model->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/color');
    }

    public function delete(Request $req,$id)
    {
        $model=Color::find($id);
        $model->delete();
        $req->session()->flash('message','Size Deleted');
        return redirect('/admin/color');
    }

    public function status(Request $req, $status,$id)
    {
        $model=Color::find($id);
        $model->status=$status;
        $model->save();
        $req->session()->flash('message','Color Satatus Updated');
        return redirect('/admin/color');
    }
}
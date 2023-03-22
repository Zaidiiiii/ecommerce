<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupan;
use Illuminate\Http\Request;

class CoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Coupan::all();
        return view('admin.coupan',$result);
    }

    
    public function manage_coupan(Request $req,$id='')
    {
        if($id>0){
            $arr=Coupan::where(['id'=>$id])->get();

            $result['title']=$arr['0']->title;
            $result['code']=$arr['0']->code;
            $result['value']=$arr['0']->value;
            $result['type']=$arr['0']->type;
            $result['min_order_amt']=$arr['0']->min_order_amt;
            $result['is_one_time']=$arr['0']->is_one_time;
            $result['id']=$arr['0']->id;
        }else{
            $result['title']='';
            $result['code']='';
            $result['value']='';
            $result['type']='';
            $result['min_order_amt']='';
            $result['is_one_time']='';
            $result['id']='0';
        }
        return view('admin/manage_coupan',$result);
    }

    public function manage_coupan_process(Request $req)
    {
        $req->validate([
            'title'=>'required',
            'code'=>'required|unique:coupans,code,'.$req->post('id'),
            'value'=>'required',
        ]);

        if($req->post('id')>0){
            $model=Coupan::find($req->post('id'));
            $msg="Coupan updated";
        }else{
            $model=new Coupan();
            $msg="Coupan inserted";
            $model->status=1;
        }

        $model->title=$req->post('title');
        $model->code=$req->post('code');
        $model->value=$req->post('value');
        $model->type=$req->post('type');
        $model->min_order_amt=$req->post('min_order_amt');
        $model->is_one_time=$req->post('is_one_time');
        $model->status=1;
        $model->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/coupan');
    }

    public function delete(Request $req,$id)
    {
        $model=Coupan::find($id);
        $model->delete();
        $req->session()->flash('message','Coupan Deleted');
        return redirect('/admin/coupan');
        
    }

    public function status(Request $req, $status,$id)
    {
        $model=Coupan::find($id);
        $model->status=$status;
        $model->save();
        $req->session()->flash('message','Coupon Satatus Updated');
        return redirect('/admin/coupan');
    }
}
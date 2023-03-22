<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Tax::all();
        return view('admin.tax',$result);
    }

    
    public function manage_tax(Request $req,$id='')
    {
        if($id>0){
            $arr=Tax::where(['id'=>$id])->get();

            $result['tax_desc']=$arr['0']->tax_desc;
            $result['tax_value']=$arr['0']->tax_value;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['tax_desc']='';
            $result['tax_value']='';
            $result['status']='';
            $result['id']='0';
        }
        return view('admin/manage_tax',$result);
    }

    public function manage_tax_process(Request $req)
    {
        $req->validate([
            'tax_value'=>'required|unique:taxs,tax_value,'.$req->post('id'),
        ]);

        if($req->post('id')>0){
            $model=Tax::find($req->post('id'));
            $msg="Tax updated";
        }else{
            $model=new Tax();
            $msg="Tax inserted";
        }

        $model->tax_desc=$req->post('tax_desc');
        $model->tax_value=$req->post('tax_value');
        $model->status=1;
        $model->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/tax');
    }

    public function delete(Request $req,$id)
    {
        $model=Tax::find($id);
        $model->delete();
        $req->session()->flash('message','Tax Deleted');
        return redirect('/admin/tax');
    }

    public function status(Request $req, $status,$id)
    {
        $model=Tax::find($id);
        $model->status=$status;
        $model->save();
        $req->session()->flash('message','Tax Satatus Updated');
        return redirect('/admin/tax');
    }
}
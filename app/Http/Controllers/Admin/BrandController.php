<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Brand::all();
        return view('admin.brand',$result);
    }

    
    public function manage_brand(Request $req,$id='')
    {
        if($id>0){
            $arr=Brand::where(['id'=>$id])->get();

            $result['name']=$arr['0']->name;
            $result['image']=$arr['0']->image;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']="";
            if($arr['0']->is_home==1){
                $result['is_home_selected']="checked";
            }
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['name']='';
            $result['image']='';
            $result['is_home']='';
            $result['is_home_selected']="";
            $result['status']='';
            $result['id']='0';
        }
        return view('admin/manage_brand',$result);
    }

    public function manage_brand_process(Request $req)
    {

        $req->validate([
            'name'=>'required|unique:brands,name,'.$req->post('id'),
            'image'=>'mimes:jpeg,jpg,png'
            
        ]);


        if($req->post('id')>0){
            $model=Brand::find($req->post('id'));
            $msg="Brand updated";
        }else{
            $model=new Brand();
            $msg="Brand inserted";
        }

        if($req->hasfile('image')){

            if($req->post('id')>0){
                $arrImage=DB::table('brands')->where(['id'=>$req->post('id')])->get();
                if(Storage::exists('/public/media/brand/'.$arrImage[0]->image)){
                Storage::delete('/public/media/brand/'.$arrImage[0]->image);
            }
        }  
            $image=$req->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/brand',$image_name);
            $model->image=$image_name;
        }

        $model->name=$req->post('name');
        $model->is_home=0;
        if($req->post('is_home')!==null){
            $model->is_home=1;
        }
        $model->status=1;
        $model->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/brand');
    }

    public function delete(Request $req,$id)
    {
        $model=Brand::find($id);
        $model->delete();
        $req->session()->flash('message','Size Deleted');
        return redirect('/admin/brand');
    }

    public function status(Request $req, $status,$id)
    {
        $model=Brand::find($id);
        $model->status=$status;
        $model->save();
        $req->session()->flash('message','Brand Satatus Updated');
        return redirect('/admin/brand');
    }
}
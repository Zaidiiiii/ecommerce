@extends('admin/layout')
@section('page_title','Show Customer Details')
@section('customer_select','active')
@section('container')
@if(session()->has('message'))
<div class="sufee-alert alert with-close alert-close alert-success alert-dismissible fade show">
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">x</span>
    </button>
</div>
@endif
<h1 class="mb10">Customer Details</h1>
<br>
<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{$customer_list->name}}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{$customer_list->email}}</td>
                    </tr>
                    <tr>
                        <td><strong>Mobile</strong></td>
                        <td>{{$customer_list->mobile}}</td>
                    </tr>
                    <tr>
                        <td><strong>City</strong></td>
                        <td>{{$customer_list->city}}</td>
                    </tr>
                    <tr>
                        <td><strong>State</strong></td>
                        <td>{{$customer_list->state}}</td>
                    </tr>
                    <tr>
                        <td><strong>Zip</strong></td>
                        <td>{{$customer_list->zip}}</td>
                    </tr>
                    <tr>
                        <td><strong>Company</strong></td>
                        <td>{{$customer_list->company}}</td>
                    </tr>
                    <tr>
                        <td><strong>GST Number</strong></td>
                        <td>{{$customer_list->gstin}}</td>
                    </tr>
                    <tr>
                        <td><strong>Created at</strong></td>
                        <td>{{\Carbon\Carbon::parse($customer_list->created_at)->format('d-m-Y')}}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated at</strong></td>
                        <td>{{\Carbon\Carbon::parse($customer_list->updated_at)->format('d-m-Y')}}</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>


@endsection
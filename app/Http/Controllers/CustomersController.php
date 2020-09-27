<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
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
        $dataCus = Customers::where('customer_status',1)->get();
        $countData = $dataCus->count();
         //return $countData;
        return  view('pages.customers',compact('dataCus','countData'));
                             
    }
    public function remove(Request $request)
    {
        $idCus = $request->idCusRemove;
        if($idCus!=""){
            $process = Customers::where('customer_id',$idCus)->update(['customer_status'=>0]);
            
            if($process!=0){
                return back()->with('info', 'Đã xoá khách hàng thành công');
            }else{
                return back()->with('info', 'Không tìm thấy ID Khách hàng');
            }
           
        }else{
            return back()->with('info', 'Dữ liệu thêm rỗng');
        }
       
        
    }
    public function edit(Request $request)
    {
        $idCus = $request->idCusEdit;
        $nameCus = $request->nameCus;
        $phoneCus = $request->phoneCus;
        $addressCus = $request->addressCusEdit;
        $addressCusLatLng = $request->editLatLng;
        if($idCus!=""&&$nameCus!=""&&$phoneCus!=""&&$addressCus!="")
        {

            Customers::where('customer_id',$idCus)->update([
                'customer_name'=> $nameCus,
                'customer_phone'=> $phoneCus,
                'customer_address'=> $addressCus,
                'customer_address_latlng'=> $addressCusLatLng
            ]);
            return back()->with('info', 'Đã sửa khách hàng thành công');

        }else{
            return back()->with('info', 'Dữ liệu thêm rỗng');
        }
    
    }
     public function add(Request $request)
    {
        $nameCusAdd = $request->nameCusAdd;
        $addressCusAdd = $request->addressCusAdd;
        $addressLatLngAdd = $request->addLatLng;
        $phoneCusAdd = $request->phoneCusAdd;

        if($nameCusAdd!=""&&$addressCusAdd!=""&&$phoneCusAdd!=""){
            $customer = new Customers;

            $customer->customer_name = $nameCusAdd;
            $customer->customer_address = $addressCusAdd;
            $customer->customer_address_latlng = $addressLatLngAdd;
            $customer->customer_phone = $phoneCusAdd;
            $customer->customer_status = 1;
            $customer->save();

            return back()->with('info', 'Đã thêm khách hàng thành công');
        }else{
            return back()->with('info', 'Dữ liệu thêm rỗng');
        }
    }
}

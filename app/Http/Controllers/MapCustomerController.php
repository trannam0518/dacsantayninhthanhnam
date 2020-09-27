<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
class MapCustomerController extends Controller
{
    public function index(){
        $dataCustomer = Customers::where('customer_status',1)
                                    ->select(
                                        'customers.customer_name',
                                        'customers.customer_address_latlng'
                                    )
                                    ->get();
        $countCustomer = $dataCustomer->count();
        
        if($countCustomer!=0){
            $arr2chieuAllCus = [];
              
            for($i=0;$i<$countCustomer;$i++){
                $arr1chieuAllCus = [];
                $arrLatLng= explode("|",$dataCustomer[$i]->customer_address_latlng);                
                array_push($arr1chieuAllCus,$dataCustomer[$i]->customer_name,$arrLatLng);
                array_push($arr2chieuAllCus,$arr1chieuAllCus);               
            }

            if(count($arr2chieuAllCus)!=0){
                return view('pages.MapCustomers',compact('arr2chieuAllCus'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
        
    }
}

<?php

namespace App\Http\Controllers;

use App\OrderDetails;
use App\Orders;
use Illuminate\Http\Request;

class AllOrderController extends Controller
{
    public function index(){
        $allOrder = Orders::join('customers','order_customer_id','=','customer_id')
                            ->select(
                                'orders.*',
                                'customers.customer_name',                               
                            )->get();
        $allOrderDetail =  OrderDetails::join('products','order_detail_product_id','=','product_id')
                                        ->select(
                                                 'order_detail_order_id',
                                                 'products.product_name',
                                                OrderDetails::raw('(order_detail_price*order_detail_quantity) as totalMoney')
                                        )
                                        ->get();
        
        $countAllOrderDetail  =  $allOrderDetail->count();                     
        $countOrder = $allOrder->count();
        return view('pages.AllOrders',compact('allOrder','countOrder','countAllOrderDetail','allOrderDetail'));
    }
    public function updatestatus(Request $request){
        $idOrder = $request->idOrder;
        $statusOrder = $request->numberStatus;
        if($idOrder!=""&&$statusOrder!=""){

            $process = Orders::where('order_id',$idOrder)->update(['order_status'=>$statusOrder]);     
            if($process){
                return back()->with('info', 'Đã cập nhật thành công');
            }else{
                return back()->with('info', 'Lỗi cập nhật đơn hàng từ Database');
            }

        }else{
            return back()->with('info','Không có idOrder để sữa');
        }
    }
}

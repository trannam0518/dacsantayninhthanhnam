<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Customers;
use App\Products;
use App\OrderDetails;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $dataOrder = Orders::where('order_status','=','1')
                            ->join('customers','order_customer_id','=','customer_id')
                            ->select(
                                'orders.*',
                                'customers.customer_id',
                                'customers.customer_name',
                                'customers.customer_address',
                            )
                            ->orderBy('updated_at','desc')
                            ->orderBy('created_at','desc')
                            ->get();
        
        $arrayOrderDetail = array();
        $countOrder = $dataOrder->count();
        foreach ($dataOrder as $key => $value) {
            $dataOrderDetailAll = OrderDetails::where('order_detail_order_id','=',$dataOrder[$key]->order_id)
                                            ->join('products','order_detail_product_id','=','product_id')
                                            ->select(
                                                'order_details.*',
                                                'products.product_id',
                                                'products.product_name'
                                            )
                                            ->orderBy('updated_at','desc')
                                            ->orderBy('created_at','desc')
                                            ->get();
            array_push($arrayOrderDetail,$dataOrderDetailAll);
            
        }
        //return $dataOrder;
        //return $arrayOrderDetail;
        $dataCustomer = Customers::where('customer_status','1')->get();
        
        $countCustomer = $dataCustomer->count();

        $dataProduct = Products::where('product_status','1')->get();
        
        $countProduct = $dataProduct->count();

        $dataOrderDetail = OrderDetails::select('order_detail_unit')->distinct()->get();
        
        $countdataOrderDetail = $dataOrderDetail->count();

        return view('home',compact('arrayOrderDetail','dataOrder','countOrder','dataCustomer','countCustomer','dataProduct','countProduct','dataOrderDetail','countdataOrderDetail'));
    }


    public function complete(Request $request)
    {
        $idOrderComplete = $request->idOrderComplete;
        
        $completeOrder = Orders::where('order_id',$idOrderComplete)->get();
        if($completeOrder!=""){

            $process = Orders::where('order_id',$idOrderComplete)->update(['order_status'=>2]);
            if($process){
                return back()->with('info','Hoàn tất đơn hàng');
            }else{
                return back()->with('info','Lỗi database');
            }

        }else{
            return back()->with('info','Không tìm thấy id Order');
        }
    }
    
    public function add(Request $request)
    {
        $orderDetailVal= json_decode($request->dataProduct);                
        
        $idCus= $request->selectFormAddCus;       
        $orderNote = $request->orderNote;
        
        if($idCus!=""&&$orderDetailVal!=""){

            $checkCus = Customers::where('customer_id',$idCus)->get();

            if($checkCus!=""){

                $order = new Orders;
                $order->order_customer_id = $idCus;
                $order->order_date_completed = null;
                $order->order_status = 1;
                $order->order_note = $orderNote;
                $order->save();
                
                $orderId = $order->id;
        

                if($orderId!=""){

                    $dataInsetOrder = array();

                    foreach ($orderDetailVal as $key => $value) {  

                        $product = Products::where('product_id',$value->idProduct)->get();
                        
                        if($product!=""){

                            $idProduct = $value->idProduct;        
                            $orderPrice = $value->orderPrice;
                            $orderAmount = $value->orderAmount;
                            $orderUnit = $value->orderUnit;
                            $orderCostTransport = $value->orderCostTransport;

                            $dataInsetOrderDetail =array(
                                'order_detail_order_id'         =>  $orderId,
                                'order_detail_product_id'       =>  $idProduct,
                                'order_detail_price'            =>  $orderPrice,
                                'order_detail_quantity'         =>  $orderAmount,
                                'order_detail_unit'             =>  $orderUnit,
                                'order_detail_price_transport'  =>  $orderCostTransport
                            );

                            array_push($dataInsetOrder,$dataInsetOrderDetail);

                        }else{
                            return back()->with('info', 'Không tìm thấy Id sản phẩm');
                        }
                    
                                    
                    }

                    OrderDetails::insert($dataInsetOrder);
                    return back()->with('info', 'Thêm đơn hàng thành công');

                }else{
                    return back()->with('info', 'Lỗi tạo order');
                }



            }else{
                return back()->with('info','Không có id Khách hàng này');
            }
           
        }else{
            return back()->with('info','Dữ liệu ngoài rỗng');
        }
    }

    public function edit(Request $request)
    {
        $idOrder     = $request->idOrderEdit;
        $idCus       = $request->selectNameOrderEdit;
        $noteOrder   = $request->noteOrderEdit;
        if($idOrder!=""&&$idCus!=""){

            $process = Orders::where('order_id',$idOrder)
                                ->update([
                                    'order_customer_id'     =>$idCus,                
                                    'order_note'            =>$noteOrder]);
            if($process!=0){
                return back()->with('info', 'Đã sửa thành công đơn hàng');
            }else{
                 return back()->with('info', 'Lỗi sửa đơn hàng từ Database');
            }

        }else{
            return back()->with('info','Không có order để sữa');
        }
    }

    public function remove(Request $request){
        $idOrder = $request->idOrderRemove;
        if(!empty($idOrder)){

            $process = Orders::where('order_id',$idOrder)->update(['order_status'=>0]);     
            if($process){
                return back()->with('info', 'Đã xóa thành công đơn hàng');
            }else{
                return back()->with('info', 'Lỗi xóa đơn hàng từ Database');
            }

        }else{
            return back()->with('info','Không có order để xóa');
        }
    }

    public function removedetail(Request $request)
    {

        $idOrderDetail = $request->idOrderDetailRemove;

        if(!empty($idOrderDetail)){
            
                $process = OrderDetails::where('order_detail_id',$idOrderDetail)->delete();  
            

                if($process){
                    return back()->with('info', 'Đã xóa thành công chi tiết đơn hàng');
                }else{
                    return back()->with('info', 'Lỗi xóa đơn hàng từ Database');
                }
           
            

        }else{
            return back()->with('info','Không có orderDetail để xóa');
        }

    }
    public function editdetail(Request $request)
    {
        
        $idOrderDetail = $request->idEditOrderDetail;

        $idProduct = $request->addOrderDetailPro;
        $orderDetailPrice = $request->editPriceProduct;
        $orderDetailAmount = $request->editAmountProduct;
        $orderDetailUnit = $request->editUnitProduct;
        $orderDetailTransport = $request->editTransportProduct;

        if(!empty($idOrderDetail)){

            $process = OrderDetails::where('order_detail_id',$idOrderDetail)
                            ->update([
                                'order_detail_product_id'      =>  $idProduct,
                                'order_detail_price'            =>  $orderDetailPrice,
                                'order_detail_quantity'         =>  $orderDetailAmount,
                                'order_detail_unit'             =>  $orderDetailUnit,
                                'order_detail_price_transport'  =>  $orderDetailTransport
                            ]);   
                          
            if($process!=0){
                return back()->with('info', 'Đã sữa thành công sản phẩm');
            }else{
                return back()->with('info', 'Lỗi sữa sản phẩm từ Database');
            }

        }else{
            return back()->with('info','Không có sản phẩm để sữa');
        }
               
    }
    public function adddetail(Request $request){

        $idOrder = $request->addIdOrder;
        $idProduct = $request->addOrderDetailPro;
        $addUnitProduct = $request->addUnitProduct;
        $addAmountProduct = $request->addAmountProduct;
        $addPriceProduct = $request->addPriceProduct;
        $addTransportProduct = $request->addTransportProduct;
        
        if($idOrder!=""){

            $check = Orders::where([
                                        ['order_id','=',$idOrder],
                                        ['order_status','=',1]
                                    ])->get();
            if(!empty($check)&&!empty($addUnitProduct)&&!empty($addAmountProduct)&&!empty($addPriceProduct)&&!empty($addTransportProduct)){
   
                $orderDetail = new OrderDetails;

                $orderDetail->order_detail_order_id          =  $idOrder;
                $orderDetail->order_detail_product_id        =  $idProduct;
                $orderDetail->order_detail_price             =  $addPriceProduct;
                $orderDetail->order_detail_quantity          =  $addAmountProduct;
                $orderDetail->order_detail_unit              =  $addUnitProduct;
                $orderDetail->order_detail_price_transport   =  $addTransportProduct;
                $orderDetail->save();

                $newID = $orderDetail->id;
                
                if($newID){
                    return back()->with('info', 'Thêm sản phẩm thành công');
                }else{
                    return back()->with('info', 'Không thêm được sản phẩm');
                }
            }else{
                return back()->with('info', 'Không tồn tại ID order này');
            }

        }else{
            return back()->with('info', 'Không tìm thấy Id đơn hàng');
        }       

    }
}

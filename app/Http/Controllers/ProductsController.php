<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
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
        $dataPro = Products::where('product_status',1)->get();
        $countData = $dataPro->count();
         //return $countData;
        return  view('pages.products',compact('dataPro','countData'));
       
    }
    public function add(Request $request)
    {

        $product = new Products;

        $nameProduct = $request->nameProAdd;
        $imageProduct = $request->imgBase64;
        
        if($nameProduct&&$imageProduct){
            $curl  = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://freeimage.host/api/1/upload',
                CURLOPT_POST => 1,
                CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
                CURLOPT_POSTFIELDS => http_build_query(array(
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'source' => $imageProduct,
                    'format' => 'json'

                ))
            ));
            $resp = curl_exec($curl);         
            $decodeResp = json_decode($resp);
            curl_close($curl);
           if($decodeResp->status_code ==200){
                 $product->product_name = $nameProduct;
                 $product->product_image = $decodeResp->image->url;
                 $product->product_status = 1;
                 $product->save();

                 return back()->with('info', 'Thêm sản phẩm thành công');
           }else{

             return back()->with('info', $decodeResp->error->message);

           }
                     
        }
                
    }


    public function remove(Request $request)
    {
        
        $idProduct = $request->idProRemove;
        $product = Products::where('product_id',$idProduct)->get();
        
        if($product){
            
            $process = Products::where('product_id',$idProduct)->update(['product_status'=>2]);     
            if($process){
                return back()->with('info', 'Đã xóa thành công sản phẩm');
            }else{
                return back()->with('info', 'Lỗi xóa sản phẩm từ Database');
            }
            
        }else{
            return back()->with('info', 'Không có Id sản phẩm để xóa');
        }
                                     
    }

    public function edit(Request $request)
    {

        $nameProduct = $request->nameProEdit;
        $imageProduct = $request->imgBase64Edit;
        $idProduct = $request->idProductEdit;

        $product = Products::where('product_id',$idProduct)->get();
        if($product){
            if($imageProduct==""){
                $process = Products::where('product_id',$idProduct)->update(['product_name'=>$nameProduct]);     
                if($process){
                    return back()->with('info', 'Đã sửa thành công sản phẩm');
                }else{
                    return back()->with('info', 'Lỗi sửa sản phẩm từ Database');
                }
            }else{
                
                    $curl  = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'https://freeimage.host/api/1/upload',
                        CURLOPT_POST => 1,
                        CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
                        CURLOPT_POSTFIELDS => http_build_query(array(
                            'key' => '6d207e02198a847aa98d0a2a901485a5',
                            'source' => $imageProduct,
                            'format' => 'json'
        
                        ))
                    ));
                    $resp = curl_exec($curl);         
                    $decodeResp = json_decode($resp);
                    curl_close($curl);
                   if($decodeResp->status_code ==200){
                         
                        $process = Products::where('product_id',$idProduct)->update([
                            'product_name'=>$nameProduct,
                            'product_image' => $decodeResp->image->url
                            ]);     
                        if($process){
                            return back()->with('info', 'Đã sửa thành công sản phẩm');
                        }else{
                            return back()->with('info', 'Lỗi sửa sản phẩm từ Database');
                        }

                         return back()->with('info', 'Sửa sản phẩm thành công');
                   }else{
        
                     return back()->with('info', $decodeResp->error->message);
        
                   }
                             
                

            }
        }else{
            return back()->with('info', 'Không có Id sản phẩm để xóa');
        }

        
                
    }

}

@extends('layouts.app')
@section('title', 'Orders')
@section('content')

                <div class="d-flex flex-justify-end " style="background-color:#75b5fd" >
                    <p class="p-2 mr-auto text-center text-leader">
                        Soạn đơn hàng
                    </p>
                    
                </div>


                @if(session()->has('info'))
                <h3 class="bg-red text-center" id="messageInfo">
                    {{ session()->get('info') }}
                </h3>
                @endif



                <br>
                    @for($i=0;$i<$countOrder;$i++)
                        <div class="skill-box"> 
                            <div class="d-flex flex-justify-end bg-gray fg-dark" >
                        
                                    <div class="p-2 flex-column mr-auto">
                                        <strong class="title">Tên: {{$dataOrder[$i]->customer_name}}</strong>
                                        <div class="subtitle">Địa chỉ: {{$dataOrder[$i]->customer_address}}</div>
                                        <div class="subtitle">Ngày tạo: {{$dataOrder[$i]->created_at}}</div>
                                        <div class="subtitle fg-red">Ghi chú: {{$dataOrder[$i]->order_note}}</div>
                                    </div>
                                    <div class="p-1"> 
                                        <button class="button alert m-1" onclick= "openRemoveInfobox({{$dataOrder[$i]->order_id }},'{{$dataOrder[$i]->customer_name}}')" >Xóa</button>
                                        <button class="button warning m-1" onclick= "openEditInfobox({{$dataOrder[$i]->order_id }},{{$dataOrder[$i]->customer_id}},'{{$dataOrder[$i]->customer_name}}','{{$dataOrder[$i]->order_note}}')">Sửa</button>
                                    </div>
                                    <div class="p-2" >
                                        <button style="background-color:#75b5fd" class="image-button icon-right" onclick="completeOrder({{$dataOrder[$i]->order_id }},'{{$dataOrder[$i]->customer_name}}');">                          
                                            <span class="mif-checkmark icon"></span>
                                            <span class="caption">Hoàn tất</span>                                      
                                        </button>
                                    </div>
                            
                            </div>    
                
                            <ul class="skills">
                                @foreach($arrayOrderDetail[$i] as $key => $value)
                                <li class="d-flex flex-justify-start"> 
                                    
                                    <span class="button mr-2" >{{$arrayOrderDetail[$i][$key]->product_name}}</span>
                                    
                                    <button class="mr-1"onclick="$(this).next().removeClass('d-none');setTimeout(function(){ $('button.mr-1').next().addClass('d-none'); }, 1500)"><span class="mif-pencil mif-2x"></span></button>
                                    <div class="d-none">
                                        <button class="button alert mr-2 mb-1" onclick= "openRemoveProductOrder({{$arrayOrderDetail[$i][$key]->order_detail_id}},'{{$dataOrder[$i]->customer_name}}','{{$arrayOrderDetail[$i][$key]->product_name}}')">Xóa</button>
                                        <button class="button warning mr-2" onclick="openEditProductOrder({{$arrayOrderDetail[$i][$key]->order_detail_id}},'{{$dataOrder[$i]->customer_name}}','{{$arrayOrderDetail[$i][$key]->order_detail_product_id}}','{{$arrayOrderDetail[$i][$key]->order_detail_unit}}','{{$arrayOrderDetail[$i][$key]->order_detail_price}}','{{$arrayOrderDetail[$i][$key]->order_detail_quantity}}','{{$arrayOrderDetail[$i][$key]->order_detail_price_transport}}')">Sửa</button>
                                    </div>
                                    <button class="image-button button ml-auto">
                                        <span class="icon">{{$arrayOrderDetail[$i][$key]->order_detail_quantity}}</span>
                                        <span class="caption">{{$arrayOrderDetail[$i][$key]->order_detail_unit}}</span>                                       
                                    </button>

                                </li>
                                
                                @endforeach
                                <li>
                                    <button class='button' style="background-color:#75b5fd" onclick="$('#boxAddOrderDetail').data('infobox').open();$('#addNameCus').val('{{$dataOrder[$i]->customer_name}}');$('#addIdCus').val('{{$dataOrder[$i]->customer_id}}');$('#addIdOrder').val('{{$dataOrder[$i]->order_id}}')">                                     
                                            <span class='mif-add'>Thêm sản phẩm</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    @endfor

                    <button  onclick="$('#formAdd').data('infobox').open();" class="action-button rotate-minus fg-white" style="position: fixed;bottom: 5px;right: 5px;z-index: 99;background-color: #75b5fd">
                        <span class="icon mif-plus"></span>
                    </button>
                    
                    <!-- dialog hoan tat soan don -->
                    <div id="completeOrder" class="dialog" data-role="dialog">
                        <form action="order/complete" method="POST">
                            @csrf 
                                        <div class="dialog-title bg-blue">Hoàn tất soạn hàng?</div>
                                        <div id="dialog-contents" class="dialog-content fg-red"></div>
                                        <input type="text" id="idOrderComplete" name="idOrderComplete" hidden>
                                        <div class="dialog-actions">
                                            <button class="button alert">Đồng ý</button>
                                            <button class="button js-dialog-close" onclick="event.preventDefault();">Hủy bỏ</button>
                                        </div>
                        </form>
                    </div>
                    <!-- --------------- -->
            
                    <!-- form Add product -->

                    <div style="overflow:scroll" id="formAdd" class="info-box" data-role="infobox" data-close-button>
                        <span class="button square closer" onclick="closeFormAddOrder();"></span>
                        <div  class="dialog-title bg-blue fg-white text-center">Tạo đơn hàng</div> 
                            <div class="bg-white p-4">
                                
                                <form data-role="validator" id="formAddProduct" action="order/add" method="POST">   
                                @csrf
                                        <label class="text-bold">Khách hàng</label>
                                        <select data-role="select"
                                                data-validate="required not=-1"
                                                data-filter-placeholder="Tìm khách hàng"
                                                id="selectFormAddCus";
                                                name="selectFormAddCus";
                                        >
                                            <option value="-1" class="d-none"></option>
                                            @for($i=0;$i<$countCustomer;$i++)
                                                <option value="{{$dataCustomer[$i]->customer_id}}" >{{$dataCustomer[$i]->customer_name}}</option>
                                            @endfor
                                        
                                        </select>
                                        <span class="invalid_feedback">
                                            Vui lòng chọn 1 khách hàng
                                        </span>




                                        <div class="mt-2 text-center">
                                            <h3>Danh sách sản phẩm</h3>
                                            <ol id="listProduct">
                                            
                                            </ol>
                                        </div>
                                        <div class="text-center mt-2">
                                            <button class="button bg-cyan" onclick="event.preventDefault();$('#boxOrderDetail').data('infobox').open()">
                                                <span class="mif-add "></span>
                                                <span>Thêm sản phẩm</span>
                                            </button>
                                        </div>
                                        


                                        <input type="text" id="dataProduct" name="dataProduct" data-validate="required"hidden>
                                        <span class="invalid_feedback text-center">
                                            Vui lòng thêm sản phẩm
                                        </span>
                                        
                                        <label class="text-bold mt-2">Ghi chú</label>
                                        <textarea data-role="textarea" id="orderNote" name="orderNote"></textarea>
                                        
                                                            
                                    <div class="row mt-2 pl-2">
                                    <button class="button mr-2 bg-cyan" >Thêm</button>
                                    <button class="button js-dialog-close" onclick="closeFormAddOrder();">Hủy bỏ</button>
                                    </div>
                                </form>  

                            </div>     
                                    
                                
                        </div>
                    </div>

                    <!-- ----------------- -->


                    <!-- form Add detail -->

                    <div style="overflow:scroll" id="boxOrderDetail" class="info-box" data-role="infobox" data-close-button>
                        <span class="button square closer" onclick="closeFormAddOrderDetail()"></span>
                        <div  class="dialog-title bg-blue fg-white text-center">Chi tiết sản phẩm</div>
                        <div class="bg-white p-4">
                        <form data-role="validator" id="formOrderDetail"  data-on-validate-form="addProductDetail();">
                            <div class="form-group" >

                                <label class="text-bold">Tên sản phẩm</label>
                                <select data-role="select"
                                        data-validate="required not=-1"
                                        data-filter-placeholder="Tìm sản phẩm"
                                        id="selectFormAddPro";
                                       
                                >
                                        <option value=-1 class="d-none"></option>
                                    @for($i=0;$i<$countProduct;$i++)
                                        <option value="{{$dataProduct[$i]->product_id}}" >{{$dataProduct[$i]->product_name}}</option>
                                    @endfor
                                </select>
                                <span class="invalid_feedback">
                                    Sản phẩm không được trống
                                </span>

                                <label class="text-bold">Đơn vị tính</label>
                                <input type="text" id="orderUnit" class="mb-2 fg-black" data-validate="required">                           
                                <span class="invalid_feedback">
                                    Vui lòng chọn đợn vị tính
                                </span>

                                <div class="mb-5"                                                   
                                            style=" height:100px;                                                                                                       
                                                    overflow:scroll;"
                                        >
                                @for($i=0;$i<$countdataOrderDetail;$i++)
                                <a class="button mb-2" onclick="$('#orderUnit').val($(this).text())">{{$dataOrderDetail[$i]->order_detail_unit}}</a>                               
                                @endfor
                                </div>

                                <label class="text-bold mt-2">Giá sản phẩm</label>
                                <input type="text" id="orderPrice" data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></>
                                <span class="invalid_feedback">
                                    Vui lòng ghi giá sản phẩm bằng số
                                </span>

                                <div><label class="text-bold">Số lượng</label></div>
                                <input type="number" id="orderAmount" data-validate="required number"> 
                                <span class="invalid_feedback">
                                    Vui lòng ghi số lượng bằng số
                                </span>
                                                                               
                                <label class="text-bold mt-2">Cước vận chuyển</label>
                                <input type="text" id="orderCostTransport"  data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></input>
                                <span class="invalid_feedback">
                                    Vui lòng ghi cước vận chuyển bằng số
                                </span>
                                                       
                                <div class="row mt-2 pl-2">
                                    <button class="button mr-2 bg-cyan">Thêm</button>
                                    <button class="button js-dialog-close" onclick="closeFormAddOrderDetail()">Hủy bỏ</button>
                                </div>
                            </div>                                   
                        </form>
                        </div>
                    </div>

                    <!-- --------------- -->


                    <!-- form Edit Order -->
     
                    <div    style="overflow:scroll" 
                            id="formEdit" class="info-box" 
                            data-role="infobox" 
                            data-close-button>
                        <span class="button square closer"></span>
                        <div  class="dialog-title bg-blue fg-white text-center">Sửa đơn hàng</div> 
                            <div class="bg-white p-4">
                                
                                <form data-role="validator" id="formEditProduct" action="order/edit" method="POST">   
                                    @csrf

                                        

                                        <label class="text-bold">Khách hàng</label>
                                        <input type="text" id="idOrderEdit" name="idOrderEdit" data-validate="required" hidden>
                                        <span class="invalid_feedback">
                                            Thiếu Id đơn hàng
                                        </span>

                                        <input type="text" id="nameCusOrderEdit"  data-validate="required" disabled>                                       
                                        <span class="invalid_feedback">
                                            Vui lòng chọn 1 khách hàng
                                        </span> 

                                        <div class="text-center mb-2 fg-cyan"><span>Danh sách khách hàng có thể chọn </span><span class="mif-arrow-down"></span></div>
                                        <select 
                                                data-role="select"
                                                data-filter-placeholder="Tìm khách hàng"
                                                id="selectNameOrderEdit";
                                                name="selectNameOrderEdit";
                                                data-on-change="changeNameOrderEdit($(this).find('option:selected').text())"
            
                                        >
                                            @for($i=0;$i<$countCustomer;$i++)
                                                <option value="{{$dataCustomer[$i]->customer_id}}">{{$dataCustomer[$i]->customer_name}}</option>
                                            @endfor
                                        
                                        </select>
                                                                                                                                    
                                                                               
                                        <label class="text-bold mt-2">Ghi chú</label>                                       
                                        <textarea data-role="textarea" id="noteOrderEdit" name="noteOrderEdit"></textarea>
                                            
                                                            
                                    <div class="row mt-2 pl-2">
                                    <button class="button mr-2 bg-cyan" >Thêm</button>
                                    <button class="button js-dialog-close" onclick="event.preventDefault();">Hủy bỏ</button>
                                    </div>
                                </form>  

                            </div>     
                                    
                                
                        </div>
                    </div>

                    <!-- ---------------- -->

                    <!-- form remove Order -->

                    <div id="formRemoveOrder" class="info-box" data-role="infobox" data-close-button>
                        <div id="removeName" class="dialog-title bg-red fg-white text-center"></div>  

                        <div class="bg-white p-4">
                                <form data-role="validator"  action="order/remove" method="POST">  
                                    @csrf   
                                    <input type="hidden" name="idOrderRemove" id="idOrderRemove" data-validate="required">
                                    <span class="invalid_feedback">
                                            Không tìm thấy Id Order
                                    </span>             
                                    <div class="row mb-2 d-flex flex-justify-center">
                                        <button class="button mr-2 bg-red fg-white">Xóa</button>
                                        <button class="button bg-cyan js-dialog-close" onclick="event.preventDefault();">Không xóa</button>
                                    </div>
                                </form>
                        </div>
                    </div>

                    <!-- ---------------- -->

                    <!-- remove order detail -->

                    <div id="removeOrderDetail" class="info-box" data-role="infobox" data-close-button>
                        <div id="nameOrderDetail" class="dialog-title bg-red fg-white text-center"></div>  

                        <div class="bg-white p-4">
                                <form data-role="validator"  action="order/removedetail" method="POST">  
                                    @method('DELETE')
                                    @csrf   
                                    <input type="hidden" name="idOrderDetailRemove" id="idOrderDetailRemove" data-validate="required">   
                                    <span class="invalid_feedback">
                                            Không tìm thấy Id OrderDetail
                                    </span>          
                                    <div class="row mb-2 d-flex flex-justify-center">
                                        <button class="button mr-2 bg-red fg-white" >Xóa</button>
                                        <button class="button bg-cyan js-dialog-close" onclick="event.preventDefault();">Không xóa</button>
                                    </div>
                                </form>
                        </div>
                    </div>

                    <!-- ---------------------  -->

                    <!-- edit order detail -->

                    <div style="overflow:scroll" id="boxEditOrderDetail" class="info-box" data-role="infobox" data-close-button>
                    <span class="button square closer" onclick="$('#formEditOrderDetail')[0].reset();$('#addOrderDetailPro').data('select').val(-1);"></span>
                        <div  class="dialog-title bg-blue fg-white text-center">Sửa sản phẩm</div>
                        <div class="bg-white p-4">
                        <form data-role="validator" id="formEditOrderDetail" action="order/editdetail" method="POST" data-on-validate-form="convertCurrencyToNumber($('#editPriceProduct').val(),$('#editTransportProduct').val(),'editPriceProduct','editTransportProduct');">
                            @csrf
                            <div class="form-group" >

                                <input hidden type="text" id="idEditOrderDetail" name="idEditOrderDetail" data-validate="required">
                                <span class="invalid_feedback">
                                    Id OrderDetail không được trống
                                </span>

                                <label class="text-bold">Tên khách hàng</label>
                                <input type="text" disabled id="editNameCus"  class="fg-black">


                                <label class="text-bold">Tên sản phẩm</label>
                                <select data-role="select" id=addOrderDetailPro name="addOrderDetailPro" data-validate="required not=-1">
                                    <option value="-1" class="d-none"></option>
                                    @for($i=0;$i<$countProduct;$i++)
                                        <option value="{{$dataProduct[$i]->product_id}}">{{$dataProduct[$i]->product_name}}</option>
                                    @endfor()
                                </select>
                                <span class="invalid_feedback">
                                    Tên sản phẩm không được trống
                                </span>

                                <label class="text-bold">Đơn vị tính</label>
                                <input type="text" id="editUnitProduct" name="editUnitProduct" class="mb-2 fg-black" data-validate="required">                           
                                <span class="invalid_feedback">
                                    Vui lòng chọn đợn vị tính
                                </span>

                                <div class="mb-5"                                                   
                                            style=" width:100%;
                                                    height:100px;                                                                                                       
                                                    overflow:scroll;"
                                        >
                                @for($i=0;$i<$countdataOrderDetail;$i++)
                                <a class="button mb-2" onclick="$('#editUnitProduct').val($(this).text())">{{$dataOrderDetail[$i]->order_detail_unit}}</a>                               
                                @endfor
                                </div>

                                <label class="text-bold mt-2">Giá sản phẩm</label>
                                <input type="text" id="editPriceProduct" name="editPriceProduct" data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></input>
                                <span class="invalid_feedback">
                                    Vui lòng ghi giá sản phẩm bằng số
                                </span>

                                <div><label class="text-bold">Số lượng</label></div>
                                <input type="number" id="editAmountProduct" name="editAmountProduct"data-validate="required number"> 
                                <span class="invalid_feedback">
                                    Vui lòng ghi số lượng bằng số
                                </span>
                            
                                
                                <label class="text-bold mt-2">Cước vận chuyển</label>
                                <input type="text" id="editTransportProduct" name="editTransportProduct" data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></input>
                                <span class="invalid_feedback">
                                    Vui lòng ghi cước vận chuyển bằng số
                                </span>
                            
                                

                                
                                <div class="row mt-2 pl-2">
                                    <button class="button mr-2 bg-cyan">Thêm</button>
                                    <button class="button js-dialog-close" onclick="event.preventDefault();$('#formEditOrderDetail')[0].reset();$('#addOrderDetailPro').data('select').val(-1);">Hủy bỏ</button>
                                </div>
                            </div>                                   
                        </form>
                        </div>
                    </div>


                    <!-- --------------------- -->


                    <!-- Add orderDetail -->

                    <div style="overflow:scroll" id="boxAddOrderDetail" class="info-box" data-role="infobox" data-close-button>
                    <span class="button square closer" onclick="$('#formAddOrderDetail')[0].reset();$('#addOrderDetailPro').data('select').reset();"></span>
                    <div  class="dialog-title bg-blue fg-white text-center">Thêm sản phẩm</div>
                    <div class="bg-white p-4">
                        <form data-role="validator" id="formAddOrderDetail" action="order/adddetail" method="POST" data-on-validate-form="convertCurrencyToNumber($('#addPriceProduct').val(),$('#addTransportProduct').val(),'addPriceProduct','addTransportProduct');">
                            @csrf
                            <div class="form-group" >
                                <input hidden type="text" id="addIdOrder" name="addIdOrder" data-validate="required">
                                <span class="invalid_feedback">
                                    Thiếu Id đơn hàng
                                </span>
                                <label class="text-bold">Khách hàng</label>
                                <input type="text" disabled id="addNameCus" class="fg-black" data-validate="required">
                                <span class="invalid_feedback">
                                    Tên khách hàng không được trống
                                </span>

                                <label class="text-bold">Sản phẩm</label>
                                <select data-role="select" name="addOrderDetailPro" id="addOrderDetailPro" data-validate="required not=-1">
                                   <option class="d-none" value="-1"></option>
                                    @for($i=0;$i<$countProduct;$i++) 

                                        <option value="{{$dataProduct[$i]->product_id}}">{{$dataProduct[$i]->product_name}}</option>
                                                                           
                                    @endfor
                                </select>                                                              
                                <span class="invalid_feedback mb-2">
                                    Vui lòng chọn sản phẩm
                                </span>                                               

                                <label class="text-bold">Đơn vị tính</label>
                                <input type="text" id="addUnitProduct" name="addUnitProduct" class="mb-2 fg-black" data-validate="required">                           
                                <span class="invalid_feedback">
                                    Vui lòng chọn đợn vị tính
                                </span>

                                <div class="mb-5"                                                   
                                            style=" width:100%;
                                                    height:100px;                                                                                                       
                                                    overflow:scroll;"
                                        >
                                @for($i=0;$i<$countdataOrderDetail;$i++)
                                <a class="button mb-2" onclick="$('#addUnitProduct').val($(this).text())">{{$dataOrderDetail[$i]->order_detail_unit}}</a>                               
                                @endfor
                                </div>

                                <label class="text-bold mt-2">Giá sản phẩm</label>
                                <input type="text" id="addPriceProduct" name="addPriceProduct" data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></input>
                                <span class="invalid_feedback">
                                    Vui lòng ghi giá sản phẩm bằng số
                                </span>


                                <div><label class="text-bold">Số lượng</label></div>
                                <input type="number" id="addAmountProduct" name="addAmountProduct"data-validate="required number"> 
                                <span class="invalid_feedback">
                                    Vui lòng ghi số lượng bằng số
                                </span>
                        
                                
                                <label class="text-bold mt-2">Cước vận chuyển</label>

                                <input type="text" id="addTransportProduct" name="addTransportProduct" data-validate="required" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" ></input>
                                <span class="invalid_feedback">
                                    Vui lòng ghi cước vận chuyển bằng số
                                </span>
                                
                                

                                
                                <div class="row mt-2 pl-2">
                                    <button class="button mr-2 bg-cyan">Thêm</button>
                                    <button class="button js-dialog-close" onclick="event.preventDefault();$('#formAddOrderDetail')[0].reset();$('#addOrderDetailPro').data('select').reset();">Hủy bỏ</button>
                                </div>
                            </div>                                   
                        </form>
                    </div>
                    </div>                   



                    <!-- ---------------- -->
    
     <script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>

    <script>
            $(document).ready(function() {

                // an hien message info
                $('#messageInfo').fadeIn().delay(2500).fadeOut();    


              
                //định dạng tiền tệ

                $("input[data-type='currency']").on({
                    keyup: function() {
                    formatCurrency($(this));
                    },
                    blur: function() { 
                    formatCurrency($(this), "blur");
                    },              
                });
                

            });
    </script>

    <!-- form Add order -->

    <script>
        var arrayProduct = [];
    function addProductDetail(){
        let priceOrder = convertCurrencyToBigInt($('#orderPrice').val());
        let costTransportOrder = convertCurrencyToBigInt($('#orderCostTransport').val());
        event.preventDefault();
        var product = 
        {
            idProduct: $('#selectFormAddPro').val(),
            orderUnit: $('#orderUnit').val(),
            orderAmount: $('#orderAmount').val(),
            orderPrice: priceOrder,
            orderCostTransport: costTransportOrder
        };
        
        arrayProduct.push(product);
        
        $('#dataProduct').val(JSON.stringify(arrayProduct));
        $("#listProduct").append('<li>'+$("#selectFormAddPro").find("option:selected").text()+': '+product.orderAmount+product.orderUnit+'</li>')
        $('#selectFormAddPro').data('select').val(-1);
        $('#formOrderDetail')[0].reset();
        $('#boxOrderDetail').data('infobox').close();              
    }
    
    function convertCurrencyToNumber(priceCurrency,costTransport,inputPrice,inputCost){

        var priceNumber = convertCurrencyToBigInt(priceCurrency);
        $('#'+inputPrice).val(priceNumber);
        var costNumber = convertCurrencyToBigInt(costTransport);
        $('#'+inputCost).val(costNumber);     

    }

    function closeFormAddOrder(){   
        event.preventDefault();
        $('#listProduct').empty();  
        $("#selectFormAddCus").data('select').val(-1);
        $('#formAddProduct')[0].reset();
    }

    function closeFormAddOrderDetail(){   
        event.preventDefault();
        $('#formOrderDetail')[0].reset();
        $('#selectFormAddPro').data('select').val(-1)
    }

    function changeNameOrderEdit(nameCus)
    {
        $('#nameCusOrderEdit').val(nameCus);                   
    }
        
   
    function openEditInfobox(idOrder,idCus,nameCus,orderNote){
        
        $('#idOrderEdit').val(idOrder);
        $('#nameCusOrderEdit').val(nameCus);
        $("#selectNameOrderEdit").data('select').val(idCus);
        $('#noteOrderEdit').val(orderNote);
        $('#formEdit').data('infobox').open();       
    }

    function openRemoveInfobox(idOrder,nameCus){
        $('#idOrderRemove').val(idOrder);
        $('#removeName').text('Xóa đơn hàng của: ' + nameCus);
        $('#formRemoveOrder').data('infobox').open();
    }

    function openEditProductOrder(irOrderDetail,nameCus,idPro,unitPro,pricePro,quantityPro,transportPro){
        $('#idEditOrderDetail').val(irOrderDetail);
        $('#editNameCus').val(nameCus);
        $('#addOrderDetailPro').data('select').val(idPro);
        $('#editUnitProduct').val(unitPro);
        formatCurrency($('#editPriceProduct').val(pricePro));
        $('#editAmountProduct').val(quantityPro);
        formatCurrency($('#editTransportProduct').val(transportPro));
        $('#boxEditOrderDetail').data('infobox').open();
    }

    function openRemoveProductOrder(idOrder,nameCus,namePro){
        $('#nameOrderDetail').empty();
        $('#idOrderDetailRemove').val(idOrder);
        $('#nameOrderDetail').append("<span class='fg-dark'>Khách hàng: "+nameCus+"</span>"+"</br>"+"<span>Sản phẩm xóa: "+namePro+"</span>");
        $('#removeOrderDetail').data('infobox').open();
    }

    // complete Order
    function completeOrder(idOrder,nameCus){        
        $('#idOrderComplete').val(idOrder);
        $('#dialog-contents').text('Hoàn tất chuẩn bị hàng của khách: '+nameCus);
        $('#completeOrder').data('dialog').open();                        
                                    
    }

     // removeOrderDetail
     function removeOrderDetail(idOrderDetail,nameOrderDetail){
                 
         $("#removeOrderDetail").data('infobox').open();
         $("#nameOrderDetail").text('Xóa đơn hàng: '+nameOrderDetail);
         $("#idOrderDetailRemove").val(idOrderDetail);        
                                         
     }

     
     function convertCurrencyToBigInt(currency){
        
        $convertCurency = currency.replace(" VNĐ", "");

        $bitInt = Number($convertCurency.replaceAll(",", ""));
        
        return $bitInt;

    }

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.
    
    // get input value
    var input_val = input.val();
    
    // don't validate empty input
    if (input_val === "") { return; }
    
    // original length
    var original_len = input_val.length;
        
    // initial caret position 
    var caret_pos = input.prop("selectionStart");
        
    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);
        

        // validate right side
        right_side = formatNumber(right_side);
        
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
        right_side += "00";
        }
        
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 0);

        // join number by .
        input_val = left_side  + "" + right_side+" VNĐ";

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val =  input_val+" VNĐ" ;
        
        // final formatting

        // if (blur === "blur") {
        // input_val += ".00";
        // }
    }
    
    // send updated string to input
    input.val(input_val);
       
    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
    }

    
    </script>

@endsection
@extends('layouts.app')
@section('title','All Orders')
@section('content')


<div class="m-3">

    <div class="d-flex flex-justify-end bg-gray" >
            <p class="mr-auto p-2 text-center text-leader ">
                Danh sách đơn hàng
            </p>
    </div>


             @if(session()->has('info'))
                <h3 class="bg-red text-center" id="messageInfo">
                    {{ session()->get('info') }}
                </h3>
                @endif  

            <div class="bg-white p-4">
               
                    <div class="p-4 mb-3 border bg-default">
                        
                        <input type="checkbox" data-role="switch" data-caption="Đã thanh toán" data-cls-caption="fg-green" onclick="setFilter('filterPayed', this.checked)">                                                                    
                        <input type="checkbox" data-role="switch" data-caption="Đã giao hàng" data-cls-caption="fg-teal" onclick="setFilter('filterDelivered', this.checked)">
                        <input type="checkbox" data-role="switch" data-caption="Đợi vận chuyển" data-cls-caption="fg-lightGreen" onclick="setFilter('filterAwaitShip', this.checked)">
                        <input type="checkbox" data-role="switch" data-caption="Chuẩn bị hàng" data-cls-caption="fg-yellow" onclick="setFilter('filterPreparing', this.checked)">
                        <input type="checkbox" data-role="switch" data-caption="Đơn hàng hủy" data-cls-caption="fg-red" onclick="setFilter('filterError', this.checked)">
                    </div>
                    <div class="d-flex flex-wrap flex-nowrap-lg flex-align-center flex-justify-center flex-justify-start-lg mb-2">
                        <div class="w-100 mb-2 mb-0-lg" id="t1_search"></div>
                        <div class="ml-2 mr-2" id="t1_rows"></div>
                        <div class="" id="t1_actions">
                            <button class="button square" onclick="$('#t1').data('table').toggleInspector()"><span class="mif-cog"></span></button>
                        </div>
                    </div>
                    <table id="t1" class="table table-border cell-border"
                        data-role="table"
                        data-search-wrapper="#t1_search"
                        data-rows-wrapper="#t1_rows"
                        data-info-wrapper="#t1_info"
                        data-pagination-wrapper="#t1_pagination"
                        data-horizontal-scroll="true"
                        data-on-draw-cell="drawCell"
                        data-filters-operator="or"
                    >
                    <thead>
                        <tr>
                            <th>Cập nhật đơn hàng</th>
                            <th >status</th>                       
                            <th >Khách hàng</th>                          
                            <th >Sản phẩm</th>                           
                            <th >TotalMoney</th>
                            <th >Ngày tạo</th>
                            <th data-sortable="true" data-sort-dir="desc">Ngày cập nhật status</th>
                            <th >Order ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i=0;$i<$countOrder;$i++)
                            <tr>
                                <td><button class="button info" onclick="updateStatusOrder({{$allOrder[$i]->order_id}},'{{$allOrder[$i]->customer_name}}','{{$allOrder[$i]->order_status}}');">Cập nhật</button></td>
                                <td>{{$allOrder[$i]->order_status}}</td>                               
                                <td>{{$allOrder[$i]->customer_name}}</td>  
                                <td>
                                @for($j=0;$j<$countAllOrderDetail;$j++)
                                    @if($allOrder[$i]->order_id == $allOrderDetail[$j]->order_detail_order_id)                                
                                        {{$allOrderDetail[$j]->product_name}}: <span class="bg-amber">{{number_format($allOrderDetail[$j]->totalMoney)}}đ</span><br>
                                    @endif
                                @endfor
                                </td>  
                                <td>
                                @for($j=0;$j<$countAllOrderDetail;$j++)
                                    @if($allOrder[$i]->order_id == $allOrderDetail[$j]->order_detail_order_id)                                
                                        {{$allOrderDetail[$j]->totalMoney}}<br>
                                    @endif
                                @endfor
                                </td>                                        
                                <td>{{$allOrder[$i]->created_at}}</td>
                                <td>{{$allOrder[$i]->updated_at}}</td>
                                <td>{{$allOrder[$i]->order_id}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    <div class="d-flex flex-column flex-justify-center">
                        <div id="t1_info"></div>
                        <div id="t1_pagination"></div>
                    </div>
                
            </div>

            <!-- infobox cap nhat don hang -->

            <div style="overflow:scroll" id="updateStatusOrder" class="info-box" data-role="infobox" data-height="1500px">
                        <div class="dialog-title bg-red fg-white text-center">
                            <span>Cập nhật trạng thái đơn hàng</span><br>                                                        
                                    <small id="nameCusStatus" class="text-bold fg-black"></small><br>
                                    <small id="statusOrder" class="text-bold fg-black"></small>                                                         
                        </div>
                         
                        <div class="p-4 text-center" id="nameStatusOrder">                         
                        </div>
            </div>

            <!-- --------------------- -->
        
            <!-- infobox confirm cap nhat order -->

            <div id="confirmUpdateStatusOrder" class="info-box" data-role="infobox" data-close-button>
                        <div class="dialog-title bg-cyan fg-white text-center">
                            <span>Chuyển đổi trạng thái</span><br>                                                                                                                                          
                        </div>
                        <div class="text-center p-1">
                            <span id="statusOld" class=""></span>
                            <span class="mif-arrow-right"></span>
                            <span id="statusNew" class="text-bold"></span>
                        </div>  
                        <form action="allorder/updatestatus" method="POST" data-role="validator" >
                            @csrf
                            <input hidden id="idOrder" name="idOrder" data-validate="required">
                            <span class="invalid_feedback">
                                Thiếu idOrder
                            </span>
                            <input hidden id="numberStatus" name="numberStatus" data-validate="required">
                            <span class="invalid_feedback">
                                Thiếu status
                            </span>
                            <div class="m-5 text-center">
                                <button class="button mr-2 bg-cyan">Đồng ý</button>
                                <button class="button js-dialog-close" onclick="event.preventDefault();">Hủy bỏ</button>
                            </div>
                        </form> 
                                                                                           
            </div>

            <!-- -------------------------------- -->


</div>

<script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // an hien message info
        $('#messageInfo').fadeIn().delay(2500).fadeOut();

    })

    function drawCell(td, value, index, head, item){

                    if (head.name === 'TotalMoney') {
                        let stringMoneyOrder = value.replace(/\s+/g, '');
                        let arrMoneyOrder = stringMoneyOrder.split("<br>");
                        let regex =  /^\d+$/;
                        let sumMoneyOrder = 0;
                        for (let key in arrMoneyOrder){
                            if(regex.test(arrMoneyOrder[key])){
                                let moneyOrderDetail = parseInt(arrMoneyOrder[key]);
                                sumMoneyOrder = sumMoneyOrder + moneyOrderDetail;
                                
                            }
                           
                        }
                        let formatMoney = sumMoneyOrder.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        $(td).html("<span class='bg-amber'>"+formatMoney+"đ"+"</span>")
                        };
                
                    if (head.name === 'status') {
                        var span = $("<code>").html(statuses[value][0]).addClass(statuses[value][1]);
                        $(td).html(span);
                    }
    }

    function setFilter(flt, checked){
                        var table = $('#t1').data('table');
                        var data;

                        if (checked) {
                            window[flt] = table.addFilter(function(row, heads){
                                var is_active_index = 0;
                                heads.forEach(function(el, i){
                                    if (el.name === "status") {
                                        is_active_index = i;
                                    }
                                });

                                data = parseInt(row[is_active_index]);

                                if (flt === 'filterAwaitShip') {
                                    return data === 2;
                                }
                                if (flt === 'filterPayed') {
                                    return data === 4;
                                }
                                if (flt === 'filterPreparing') {
                                    return data === 1;
                                }
                                if (flt === 'filterDelivered') {
                                    return data === 3;
                                }
                                if (flt === 'filterError') {
                                    return data === 0;
                                }                           
                            }, true);
                        } else {
                            table.removeFilter(window[flt], true);
                        }
    }
    function updateStatusOrder(orderId,nameCus,orderStatus){
        $('#updateStatusOrder').data('infobox').open();
        $('#nameCusStatus').text('Khách hàng: '+nameCus);
        var nameOldStatus = statuses[orderStatus][0];
        $('#statusOrder').text('Hiện tại: '+nameOldStatus);
        $('#nameStatusOrder').html("");
        var stringOldStatus = "'"+nameOldStatus+"'"
        for (let key in statuses){
            let newNameStatus = "'"+statuses[key][0]+"'";
            if(key == 4){
                if(statuses[key][0]==nameOldStatus){
                    $('#nameStatusOrder').append('<button class= "command-button bg-red fg-yellow" onclick="infoBoxConfirmStatus('+orderId+','+stringOldStatus+','+newNameStatus+','+key+')"><span class="caption">'+statuses[key][0]+'<small>Click để cập nhật trạng thái</small></span></button>');
                }else{
                    $('#nameStatusOrder').append('<button class= "command-button bg-gray fg-grayMouse" onclick="infoBoxConfirmStatus('+orderId+','+stringOldStatus+','+newNameStatus+','+key+')"><span class="caption">'+statuses[key][0]+'<small>Click để cập nhật trạng thái</small></span></button>');
                }            
                
            }else if(statuses[key][0]==nameOldStatus){
                $('#nameStatusOrder').append('<button class= "command-button bg-red fg-yellow" onclick="infoBoxConfirmStatus('+orderId+','+stringOldStatus+','+newNameStatus+','+key+')"><span class="caption">'+statuses[key][0]+'<small>Click để cập nhật trạng thái</small></span></button></br><div><span class="mif-arrow-down"><span class="mif-arrow-up"></span></div>');
            } 
            else{
                $('#nameStatusOrder').append('<button class= "command-button bg-gray fg-grayMouse" onclick="infoBoxConfirmStatus('+orderId+','+stringOldStatus+','+newNameStatus+','+key+')"><span class="caption">'+statuses[key][0]+'<small>Click để cập nhật trạng thái</small></span></button></br><div><span class="mif-arrow-down"><span class="mif-arrow-up"></span></div>');
            }             
        }
        
    }
    function infoBoxConfirmStatus(orderId,oldStatus,newStatusUpdate,key){
        if(oldStatus!=newStatusUpdate){
            $('#confirmUpdateStatusOrder').data('infobox').open();
            $('#statusOld').text("Từ: "+oldStatus);
            $('#statusNew').text("Sang: "+newStatusUpdate);
            $('#idOrder').val(orderId);
            $('#numberStatus').val(key);
        }
        
    }
</script>

@endsection
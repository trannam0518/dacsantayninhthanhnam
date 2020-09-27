@extends('layouts.app')
@section('title','Customers')
@section('content')
<!-- google map -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEIaorNzcn1XEq34JTQm_ryVk4oXwrj6I&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
    <link rel="stylesheet" href="{{asset('public/frontend/css/googleMap.css')}}">
    <!-- --------- -->
<div class="m-3">
    
        <div class="multi-action" style="position: fixed;bottom: 5px;right: 5px;z-index: 99;">
                    <button id ="show-Customer" class="action-button rotate-minus bg-green fg-white">
                        <span class="icon"><span class="mif-plus"></span></span>
                    </button>
                    <ul class="actions drop-left">
                    <li class="bg-blue"><a  id="clickAdd"><span class="mif-add"></span></a></li>
                        <li class="bg-warning"><a  id="clickEdit"><span class="mif-pencil"></span></a></li>
                        <li class="bg-red"><a id="clickRemove"><span class="mif-cancel"></span></a></li>
                    </ul>
        </div>

        <div class="d-flex flex-justify-end bg-gray mb-2" >
                <p class="mr-auto p-2 text-center text-leader ">
                    Danh sách khách hàng
                </p>         
        </div> 
        
        @if(session()->has('info'))
                <h3 class="bg-red text-center" id="messageInfo">
                    {{ session()->get('info') }}
                </h3>
         @endif

        <div id="addCus" class="d-none" >
            <div class="dialog-title bg-cyan text-center">Thêm khách hàng</div>           
            <div class="bg-gray p-4">


                <form data-role="validator" action="customers/add" method="POST" id="formAddCus">
                    @csrf
                    <div class="row mb-2">
                    
                            <label>Tên khách hàng</label>
                            <input type="text"
                                   data-validate="required"
                                   placeholder="Tên khách hàng"
                                   id="nameCusAdd"
                                   name="nameCusAdd">
                            <span class="invalid_feedback">
                                Vui lòng nhập tên khách hàng
                            </span>


                    </div>
                    <div class="row mb-2">

                        <label>Số điện thoại</label>
                        <input type="text"
                            data-validate="required"
                            placeholder="Số điện thoại"
                            id="phoneCusAdd"
                            name="phoneCusAdd">
                        <span class="invalid_feedback">
                            Vui lòng nhập sđt khách hàng
                        </span>
                       
                    </div>
                    
                    <div class="row mb-2">
                        <label>Địa chỉ</label>
                        <input type="text"
                               data-validate="required"
                               placeholder="Địa chỉ khách hàng"
                               id="addressCusAdd"
                               name="addressCusAdd"></input>
                        <span class="invalid_feedback">
                             vui lòng nhập địa chỉ khách hàng
                        </span>
                        
                    </div>
                    <input hidden type="text" id="addLatLng" name="addLatLng">
                    <div id="map"></div>
                   

                    <div class="row mt-2">
                        <button class="button mr-2 bg-cyan">Thêm</button>
                        <button class="button" onclick="event.preventDefault();$('#formAddCus')[0].reset();$('#addCus').addClass('d-none');">Hủy bỏ</button>
                    </div>
                </form>
            </div>
        </div>

            <!-- EDIT EDIT EDIT EDIT -->
            
            <div id="editCus" class="d-none" >
                <div class="dialog-title bg-cyan text-center">Sửa thông tin khách hàng</div>           
                <div class="bg-gray p-4">

                        <!-- form Edit -->
                        <form data-role="validator" action="customers/edit" method="POST"  id="formEditCus">
                            @csrf
                            <input type="hidden" name="idCusEdit" id="idCusEdit"> 
                                <div class="row mb-2">
                                
                                        <label>Tên khách hàng</label>
                                        <input type="text"
                                            data-validate="required"
                                            placeholder="Tên khách hàng"
                                            id="nameCus"
                                            name="nameCus"                                      
                                            >
                                        <span class="invalid_feedback">
                                            Vui lòng nhập tên khách hàng
                                        </span>
            
            
                                </div>
                                <div class="row mb-2">
                                
                                    <label>Số điện thoại</label>
                                    <input type="text"
                                        data-validate="required"
                                        placeholder="Số điện thoại"
                                        id="phoneCus"
                                        name="phoneCus"  
                                    >
                                    <span class="invalid_feedback">
                                        Vui lòng nhập sđt khách hàng
                                    </span>
            
            
                                </div>
                                

                                <div class="row mb-2">
                                    <label>Địa chỉ</label>
                                    <input type="text"
                                        data-validate="required"
                                        placeholder="Địa chỉ khách hàng"
                                        id="addressCusEdit"
                                        name="addressCusEdit"
                                    ></input>
                                    <span class="invalid_feedback">
                                        vui lòng nhập địa chỉ khách hàng
                                    </span>
                                </div>
                                <input hidden type="text" id="editLatLng" name="editLatLng">
                                <div id="mapEdit"></div>

                                <div class="row mt-2">
                                    <button class="button mr-2 bg-cyan">Sửa</button>

                                    <button class="button js-dialog-close" onclick="uncheckTable();$('#formEditCus')[0].reset();$('#editCus').addClass('d-none');">Hủy bỏ</button>
                                </div>
                            </form>

                </div>
            
            </div>
                
                                   
        
        


        
            

        <div class="bg-white p-4">
            <div class="d-flex flex-wrap flex-nowrap-lg flex-align-center flex-justify-center flex-justify-start-lg mb-2">
                <div class="w-100 mb-2 mb-0-lg" id="t1_search"></div>
                <div class="ml-2 mr-2" id="t1_rows"></div>
                <div class="" id="t1_actions">
                    <button class="button square" onclick="$('#t1').data('table').toggleInspector()"><span class="mif-cog"></span></button>
                </div>
            </div>
            <table id="t1" class="table table-border cell-border"
                    data-role="table"
                    data-check="false"
                    data-check-type ="radio"
                    data-search-wrapper="#t1_search"
                    data-rows-wrapper="#t1_rows"
                    data-info-wrapper="#t1_info"
                    data-pagination-wrapper="#t1_pagination"
                    data-horizontal-scroll="true"
                    data-on-check-click="changeEditCus"
                    >
                    <thead>
                    <tr>                       
                        <th >Tên </th>
                        <th >Địa chỉ</th>                       
                        <th >Số điện thoại</th>
                        <th >Tọa Độ</th>
                        <th data-sortable="true" data-sort-dir="desc" >Update Day</th>
                        <th >ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<$countData;$i++)
                        <tr>                           
                            <td>{{$dataCus[$i]->customer_name}}</td>
                            <td>{{$dataCus[$i]->customer_address}}</td>                   
                            <td>{{$dataCus[$i]->customer_phone}}</td>
                            <td>{{$dataCus[$i]->customer_address_latlng}}</td> 
                            <td>{{$dataCus[$i]->updated_at}}</td>
                            <td>{{$dataCus[$i]->customer_id}}</td>
                        </tr>
                    @endfor
                    </tbody>
            </table>
            <div class="d-flex flex-column flex-justify-center">
                <div id="t1_info"></div>
                <div id="t1_pagination"></div>
            </div>
        </div>
        
        <div id="infowindow-content">
            <img src="" width="16" height="16" id="place-icon" />
            <span id="place-name" class="title"></span><br />
            <span id="place-address"></span>
        </div>
</div>




        <!-- form remove -->
        <div id="formRemove" class="info-box" data-role="infobox" data-close-button>
            <div id="removeName" class="dialog-title bg-red fg-white text-center"></div>              
                <div class="bg-white p-4">
                    <form data-role="validator" id="formRemove" action="customers/remove" method="POST">  
                        @csrf   
                        <input type="hidden" name="idCusRemove" id="idCusRemove">             
                        <div class="row mb-2 d-flex flex-justify-center">
                            <button class="button mr-2 bg-red fg-white">Xóa</button>
                            <button class="button bg-cyan js-dialog-close" onclick="uncheckTable()">Không xóa</button>
                        </div>
                    </form>
                </div>
        </div>


    



<script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>
<script>
    $(document).ready(function() {

        // an hien message info
        $('#messageInfo').fadeIn().delay(2500).fadeOut();

        $('#show-Customer').on("click", function(e){

            $(this).toggleClass('active');

            $('#editCus').addClass("d-none");
            $('#addCus').addClass("d-none");
            var table = $('#t1').data('table');
            var itemTable = table.clearSelected();

            var attr = $('#t1').attr("data-check");
            if(attr =="false"){
                $('#t1').attr("data-check", "true");
            }else{
                $('#t1').attr("data-check", "false");
            }
            
        });

        $('#clickAdd').on("click", function(e){
            window.scrollTo(0,0);
            $('#addCus').removeClass('d-none');
            $('#editCus').addClass('d-none');

        })

        $('#clickEdit').on("click", function(e){
            window.scrollTo(0,0);
            var table = $('#t1').data('table');
            var itemTable = table.getSelectedItems();
            if(itemTable.length==0){
                Metro.infobox.create("<p>Hãy chọn người để sữa</p>", "alert");
            }else{

                $('#editCus').removeClass('d-none');
                $('#addCus').addClass('d-none');

                $('#nameCus').val(itemTable[0][0]);
                $('#addressCusEdit').val(itemTable[0][1]);
                $('#phoneCus').val(itemTable[0][2]);
                $('#editLatLng').val(itemTable[0][3]);
                $('#idCusEdit').val(itemTable[0][5])
                                                              
                initMap();
            }
        })

        $('#clickRemove').on("click", function(e){

            var table = $('#t1').data('table');
            var itemTable = table.getSelectedItems();
            if(itemTable.length==0){
                Metro.infobox.create("<p>Hãy chọn người để xóa</p>", "alert");
            }else{
                $('#idCusRemove').val(itemTable[0][5]);
                $('#removeName').text('Xóa khách hàng: '+ itemTable[0][0]);
                $('#formRemove').data('infobox').open();
            }                    
        })  
        

    });
</script>
<script>
    function uncheckTable(){
        event.preventDefault();

        var table = $('#t1').data('table');
        var itemTable = table.clearSelected();
        
        var attr = $('#t1').attr("data-check");
            if(attr =="false"){
                $('#t1').attr("data-check", "true");
            }else{
                $('#t1').attr("data-check", "false");
            }
        $('#addCus').addClass('d-none');
        $('#editCus').addClass('d-none');
        $('#show-Customer').removeClass('active');
    }
    function changeEditCus(){
        var table = $('#t1').data('table');
        var itemTable = table.getSelectedItems();
        $('#editCus').removeClass('d-none');
        $('#addCus').addClass('d-none');

        $('#nameCus').val(itemTable[0][0]);
        $('#addressCusEdit').val(itemTable[0][1]);
        $('#phoneCus').val(itemTable[0][2]);
        $('#editLatLng').val(itemTable[0][3]); 
        $('#idCusEdit').val(itemTable[0][5]);
                                            
        initMap();
        window.scrollTo(0,0);    
    }
</script>


<script>
      "use strict";

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      function initMap() {
        
        const map = new google.maps.Map(document.getElementById("map"), {
          center: {
            lat: 14.058324,
            lng: 108.277199
          },
          zoom: 4
        });
        const mapEdit = new google.maps.Map(document.getElementById("mapEdit"), {
          center: {
            lat: 14.058324,
            lng: 108.277199
          },
          zoom: 4
        });
        
        // init marker Edit
        var initMarkerEdit = new google.maps.Marker();
   
              
        let cusLatLng = document.getElementById("editLatLng").value;                  
        if(cusLatLng!=""){
            let arr = cusLatLng.split("|");     
            let myLatLng = {lat: Number(arr[0]), lng: Number(arr[1])};
            
            mapEdit.setCenter(myLatLng);
            mapEdit.setZoom(15);

            initMarkerEdit.setPosition(myLatLng);
            initMarkerEdit.setMap(mapEdit);                      
        }else{
            initMarkerEdit.setMap(null);
            mapEdit.setCenter({lat: 14.058324, lng: 108.277199});
            mapEdit.setZoom(4);
        }
                          
    
                               

        const inputAdd = document.getElementById("addressCusAdd");
        const inputEdit = document.getElementById("addressCusEdit");
        const autocompleteAdd = new google.maps.places.Autocomplete(inputAdd);
        const autocompleteEdit = new google.maps.places.Autocomplete(inputEdit);

         // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.

        autocompleteAdd.bindTo("bounds", map); // Set the data fields to return when the user selects a place.
        autocompleteEdit.bindTo("bounds", mapEdit);

        autocompleteAdd.setFields([
          "address_components",
          "geometry",
          "icon",
          "name"
        ]);
        autocompleteEdit.setFields([
          "address_components",
          "geometry",
          "icon",
          "name"
        ]);

        const infowindowAdd = new google.maps.InfoWindow();
        const infowindowEdit = new google.maps.InfoWindow();

        const infowindowContentAdd = document.getElementById("infowindow-content");
        const infowindowContentEdit = document.getElementById("infowindow-content");
    
        infowindowAdd.setContent(infowindowContentAdd);
        infowindowEdit.setContent(infowindowContentEdit);
        
        const markerAdd = new google.maps.Marker({
          map,
          anchorPoint: new google.maps.Point(0, -29)
        }); 
        
        const markerEditt = new google.maps.Marker();
        
        autocompleteAdd.addListener("place_changed", () => {
          infowindowAdd.close();
          markerAdd.setVisible(false);
          const place = autocompleteAdd.getPlace();
          
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert(
              "No details available for input: '" + place.name + "'"
            );
            return;
          } // If the place has a geometry, then present it on a map.

          document.getElementById("addLatLng").value = place.geometry.location.lat()+"|"+place.geometry.location.lng();

          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Why 17? Because it looks good.
          }
           
          markerAdd.setPosition(place.geometry.location);
          markerAdd.setVisible(true);
          let address = "";

          if (place.address_components) {
            address = [
              (place.address_components[0] &&
                place.address_components[0].short_name) ||
                "",
              (place.address_components[1] &&
                place.address_components[1].short_name) ||
                "",
              (place.address_components[2] &&
                place.address_components[2].short_name) ||
                ""
            ].join(" ");
        
          }
          infowindowContentAdd.children["place-icon"].src = place.icon;
          infowindowContentAdd.children["place-name"].textContent = place.name;
          infowindowContentAdd.children["place-address"].textContent = address;
          
          infowindowAdd.open(map, markerAdd);


          
        }); // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        

        // EDIT EDIT EDIT EDIT

        
        autocompleteEdit.addListener("place_changed", () => {
          initMarkerEdit.setMap(null);
          infowindowEdit.close();
          markerEditt.setVisible(false);
          const place = autocompleteEdit.getPlace();
          
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert(
              "No details available for input: '" + place.name + "'"
            );
            return;
          } // If the place has a geometry, then present it on a map.

          document.getElementById("editLatLng").value = place.geometry.location.lat()+"|"+place.geometry.location.lng();

          if (place.geometry.viewport) {
            mapEdit.fitBounds(place.geometry.viewport);
          } else {
            mapEdit.setCenter(place.geometry.location);
            mapEdit.setZoom(17); // Why 17? Because it looks good.
          }
          
            markerEditt.setPosition({lat: place.geometry.location.lat(),lng: place.geometry.location.lng()});
            markerEditt.setMap(mapEdit); 
            markerEditt.setVisible(true);
          let address = "";

          if (place.address_components) {
            address = [
              (place.address_components[0] &&
                place.address_components[0].short_name) ||
                "",
              (place.address_components[1] &&
                place.address_components[1].short_name) ||
                "",
              (place.address_components[2] &&
                place.address_components[2].short_name) ||
                ""
            ].join(" ");
        
          }

          infowindowContentEdit.children["place-icon"].src = place.icon;
          infowindowContentEdit.children["place-name"].textContent = place.name;
          infowindowContentEdit.children["place-address"].textContent = address;
          infowindowEdit.setContent(infowindowContentEdit);
          infowindowEdit.open(mapEdit, markerEditt);


          
        }); // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete. 
                     
      }

</script>
@endsection


@extends('layouts.app')
@section('title','Map Customers')
@section('content')
<!-- google map -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEIaorNzcn1XEq34JTQm_ryVk4oXwrj6I&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
<div class="m-3">

    <div class="bg-gray " >
           
    </div>


    @if(session()->has('info'))
    <h3 class="bg-red text-center" id="messageInfo">
        {{ session()->get('info') }}
    </h3>
    @endif  
      <input hidden id="dataCus" value="{{json_encode($arr2chieuAllCus)}}">
    <div class="bg-cyan p-1 text-center"> 
            <p class="p-2 text-leader ">
                Bản đồ vị trí khách hàng
            </p>
        
        <button id="drop" class="button alert"onclick="drop()">Click để hiển thị</button>

        <div style ="height: 480px;" id="map"></div>
    </div>
</div>

<script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>
<script>
      "use strict";

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      
      let markers = [];
      let map;

      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
            lat: 16.385657,
            lng: 106.304356,
            },
          zoom: 5
        });
      }

        var dataCustomer =document.getElementById("dataCus").value;
        function drop(){
            clearMarkers();

            if(dataCustomer!=''){
                var neighborhoods = JSON.parse(dataCustomer);

                for (let i = 0; i < neighborhoods.length; i++) {        
                    addMarkerWithTimeout(neighborhoods[i][0],Number(neighborhoods[i][1][0]),Number(neighborhoods[i][1][1]),i * 200);
                };
            }                          
        }  
        function addMarkerWithTimeout(name,lat,lng,timeout) {
            window.setTimeout(() => {
            markers.push(
                new google.maps.Marker({
                position: {lat: lat,lng :lng},
                map,
                title:name,
                animation: google.maps.Animation.DROP,
                })
            );
            }, timeout);
        }
        function clearMarkers() {

        for (let i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }

        markers = [];
      }
                                
</script>

@endsection
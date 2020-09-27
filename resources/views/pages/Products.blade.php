
@extends('layouts.app')
@section('title','Products')
 @section('content')       
        <div class="p-1 m-3">
          
                <div class="multi-action" style="position: fixed;bottom: 5px;right: 5px;z-index: 99;">
                    <button id ="show-Product" class="action-button rotate-minus bg-green fg-white">
                        <span class="icon"><span class="mif-plus"></span></span>
                    </button>
                    <ul class="actions drop-left">
                        <li class="bg-blue"><a onclick="$('#formAdd').data('infobox').open()"><span class="mif-add"></span></a></li>
                        <li class="bg-warning"><a id="clickEdit" ><span class="mif-pencil"></span></a></li>
                        <li class="bg-red"><a id="clickRemove"><span class="mif-cancel"></span></a></li>
                    </ul>
                </div>
         
            <div class="d-flex flex-justify-end bg-gray" >
                <p class="mr-auto p-2 text-center text-leader ">
                    Danh sách sản phẩm
                </p>
            </div>

            @if(session()->has('info'))
                <h3 class="bg-red text-center" id="messageInfo">
                    {{ session()->get('info') }}
                </h3>
            @endif

            <div class="bg-white p-4">
                <div class="example">
                    <!-- <p class="text-center h3 text-light">Sort by</p>
                    <div class="d-flex flex-justify-center flex-wrap m-2">
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-price','asc',true)">Price <span class="mif-arrow-up"></span></button>
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-price','desc',true)">Price <span class="mif-arrow-down"></span></button>
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-author','asc',true)">Author <span class="mif-arrow-up"></span></button>
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-author','desc',true)">Author <span class="mif-arrow-down"></span></button>
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-name','asc',true)">Name <span class="mif-arrow-up"></span></button>
                        <button class="button m-1" onclick="$('#paintings').data('list').sorting('painting-name','desc',true)">Name <span class="mif-arrow-down"></span></button>
                    </div> -->
                    <ul id="paintings"
                        data-role="list"
                        data-cls-list="unstyled-list row flex-justify-center mt-4"
                        data-cls-list-item="cell-sm-6 cell-md-4"
                    >
                    @for($i=0;$i<$countData;$i++)
                        <li>
                            <figure class="text-center">
                                <a onclick="$(this).find('input[type=radio]').prop('checked', true);
                                            $('#imageProductEdit').attr('src',$(this).find('img').attr('src'));
                                            $('#nameProEdit').val($(this).find('img').attr('alt'));
                                            $('#idProductEdit').val($(this).find('input[type=radio]').val());">
                                    <div class="img-container thumbnail ">
                                        <img src="{{$dataPro[$i]->product_image}}" alt="{{$dataPro[$i]->product_name}}">
                                    
                                        <div class="showProduct">
                                            <input 
                                            type="radio"
                                            name="idProduct"
                                            value="{{$dataPro[$i]->product_id}}"
                                            data-style="2"
                                            data-role="radio"
                                            data-caption="{{$dataPro[$i]->product_id}}"
                                            data-caption-position="right"
                                            data-cls-caption="fg-red text-bold p-6"
                                            data-cls-check="bd-red myCheck"
                                            >
                                        </div>
                                        <figcaption class="painting-author">{{$dataPro[$i]->product_name}}</figcaption>
                                    </div>
                                </a>
                            </figure>
                        </li>
                    @endfor
                        


                        
                        
                    </ul>
                </div>
            </div>
        </div>


<!-- dialog form add edit remove -->
    <!-- form add -->
    <div id="formAdd" class="info-box" data-role="infobox" style="overflow:scroll" data-close-button>
        <span class="button square  closer" onclick="resetFormAdd();"></span>
        <div class="dialog-title bg-cyan text-center">Thêm Sản Phẩm!</div>
            
            <div class="bg-white p-4">
                <form data-role="validator" action="products/add" method="POST" enctype="multipart/form-data" id="formProAdd">
                @csrf
                
                    <div class="row mb-2">
                        <label>Ảnh Sản Phẩm</label>
                        <input  type="file"
                                data-validate="required" 
                                name="fileAdd" 
                                id="fileAdd" 
                                data-role="file" 
                                data-button-title="Chọn ảnh"> 
                        <input type="text" id="imgBase64" name="imgBase64" data-validate="required" hidden>
                        <span class="invalid_feedback">
                                    Vui lòng thêm ảnh sản phẩm
                        </span>
                    </div>
   
                    <div class="row mb-2">
                    
                            <label>Tên Sản Phẩm</label>
                            <input type="text"
                                   data-validate="required"
                                   placeholder="Tên sản phẩm"
                                   id="nameProAdd"
                                   name="nameProAdd">
                            <span class="invalid_feedback">
                                Vui lòng nhập tên sản phẩm
                            </span>


                    </div>

                    
                    
                    
                    <div class="row mb-2">
                        <button class="button mr-2 bg-cyan">Thêm</button>
                        <button class="button js-dialog-close" onclick="resetFormAdd();">Hủy bỏ</button>
                    </div>
                    <div class="img-container rounded">
                        <img id="image_upload_preview" src="http://placehold.it/250x250" alt="your image" />
                    </div>
                </form>
            </div>
    </div>




        <!-- form edit -->
        <div id="formEdit" 
            class="info-box" 
            data-role="infobox" 
            style="overflow:scroll" 
            data-close-button>

            <span class="button square  closer" onclick="uncheckRadio();"></span>
            <div class="dialog-title bg-cyan text-center">Sửa thông tin sản phẩm!</div>            
            <div class="bg-white p-4">
                <form data-role="validator" action="products/edit" method="POST" enctype="multipart/form-data" id="formProEdit">
                @csrf
                    <div class="img-container rounded">
                        <img id="imageProductEdit"  alt="your image" />
                    </div>
                    <div class="row mb-2">
                        <label>Ảnh Sản Phẩm</label>
                        <input  type="file"
                                name="fileEdit" 
                                id="fileEdit" 
                                data-role="file" 
                                data-button-title="Chọn ảnh">
                        <input type="text" id="idProductEdit" name="idProductEdit" hidden> 
                        <input type="text" id="imgBase64Edit" name="imgBase64Edit" hidden>
                        
                    </div>
   
                    <div class="row mb-2">
                    
                            <label>Tên Sản Phẩm</label>
                            <input type="text"
                                   data-validate="required"
                                   placeholder="Tên sản phẩm"
                                   id="nameProEdit"
                                   name="nameProEdit">
                            <span class="invalid_feedback">
                                Vui lòng nhập tên sản phẩm
                            </span>


                    </div>

                    
                    
                    
                    <div class="row mb-2">
                        <button class="button mr-2 bg-cyan">Thêm</button>
                        <button class="button js-dialog-close" onclick="uncheckRadio();">Hủy bỏ</button>
                    </div>
                    
                </form>
            </div>
        </div>


        <!-- form remove -->
        <div id="formRemove" class="info-box" data-role="infobox" data-close-button>
            <div id="removeName" class="dialog-title bg-red fg-white text-center"></div>  

            <div class="bg-white p-4">
                    <form data-role="validator"  action="products/remove" method="POST">  
                        @csrf   
                        <input type="hidden" name="idProRemove" id="idProRemove">             
                        <div class="row mb-2 d-flex flex-justify-center">
                            <button class="button mr-2 bg-red fg-white">Xóa</button>
                            <button class="button bg-cyan js-dialog-close" onclick="uncheckRadio();">Không xóa</button>
                        </div>
                    </form>
            </div>
        </div>

   
<script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>

<script>
    $(document).ready(function() {

        // an hien message info
        $('#messageInfo').fadeIn().delay(2500).fadeOut();

        $('.showProduct').hide();
        $('#show-Product').on("click", function(e){
            $(this).toggleClass('active');
            $('.showProduct').toggle();
        });
        // formRemove
        $('#clickRemove').on("click", function(e){
            var radioValue = $("input[name='idProduct']:checked").val();

            if(!radioValue){
                Metro.infobox.create("<p>Hãy chọn sản phẩm để xóa</p>", "alert");
            }else{
                $('#idProRemove').val(radioValue);
               $('#removeName').text('Xóa sản phẩm số: ' + radioValue);
                $('#formRemove').data('infobox').open();
            
            }
                               
        }) 
        // formEdit
        $('#clickEdit').on("click", function(e){
            var radioValue = $("input[name='idProduct']:checked").val();
            
            if(!radioValue){
                Metro.infobox.create("<p>Hãy chọn sản phẩm để sữa</p>", "alert");
            }else{
                $('#idProRemove').val(radioValue);

                $('#formEdit').data('infobox').open();
            
            }
                               
        }) 

    });
</script>
<!-- formEdit -->
<script>
    $(document).ready(function() {    

            function imgProductEdit(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imageProductEdit').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            $("#fileEdit").change(function () {
                imgProductEdit(this);
                var filesSelected = document.getElementById("fileEdit").files;
                if (filesSelected.length > 0) {
                    var fileToLoad = filesSelected[0];

                    var fileReader = new FileReader();

                    fileReader.onload = function(fileLoadedEvent) {
                        var srcData = fileLoadedEvent.target.result; // <--- data: base64

                        

                        document.getElementById("imgBase64Edit").value = srcData.slice(23);
                        //alert("Converted Base64 version is " + srcData);
                    }
                    fileReader.readAsDataURL(fileToLoad);
                } 
            });
    })
</script>

<!-- formAdd -->
<script>
    $(document).ready(function() {    
            function filePreview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image_upload_preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#fileAdd").change(function () {
                filePreview(this);
                var filesSelected = document.getElementById("fileAdd").files;
                if (filesSelected.length > 0) {
                    var fileToLoad = filesSelected[0];

                    var fileReader = new FileReader();

                    fileReader.onload = function(fileLoadedEvent) {
                        var srcData = fileLoadedEvent.target.result; // <--- data: base64
                      
                        document.getElementById("imgBase64").value = srcData.slice(23);
                        //alert("Converted Base64 version is " + srcData);
                    }
                    fileReader.readAsDataURL(fileToLoad);
                } 
            });
    })
</script>
<script>
    function uncheckRadio(){
            event.preventDefault();
            $('input[name=idProduct]').prop('checked',false);
        }
    function resetFormAdd(){
        event.preventDefault();        
        var srcImg = "http://placehold.it/250x250";
        $('#image_upload_preview').prop('src',srcImg);
        $('#formProAdd')[0].reset();
    }
</script>

@endsection

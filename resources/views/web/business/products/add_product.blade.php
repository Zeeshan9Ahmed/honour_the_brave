@extends('layout.master')
@section('content')
<div class="contentBody">
    <h1 class="heading pb-4">Add New</h1>

    <form class="addnewForm" id="add_product">
        @csrf
        <div class="uploadBox">
            <label id="wrapper" for="upload11" class="xy-center">
                <i class="fa-solid fa-plus"></i>
                <input type="file" class="d-none" name="files[]" id="upload11" multiple accept=".png, .jpg, .jpeg">
            </label>
            <button type="button" id="clear_all" class="genBtn clearBtn">Clear All</button>
        </div>

        <div class="formFields">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <input type="text" class="formInput1" name="title" id="title" onKeyPress="if(this.value.length==30) return false;" placeholder="Title">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <select name="category_id" id="category_id" class="form-control formInput1">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <input type="number" class="formInput1" min="0" name="quantity" id="quantity" placeholder="Quantity">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <input type="number" class="formInput1" min="0" name="price" id="price" placeholder="Price" step="any">
                </div>
                <div class="col-12">
                    <textarea class="formInput1 formTextarea" name="detail" id="detail" placeholder="Details" onKeyPress="if(this.value.length==255) return false;"></textarea>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <button type="submit" class="genBtn addnewBtn2" id="add_product">Add</button>
                </div>
            </div>
        </div>
    </form>
    <div id="image-holder"></div>
</div>
@endsection

@section('additional_scripts')

<script>
    $(document).ready(function() {
        // MULTIPLE IMAGE UPLOADER (ADD NEW)

        $("#upload11").on('change', function() {

            //Get count of selected files
            var countFiles = $(this)[0].files.length;

            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#image-holder");
            image_holder.empty();

            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof(FileReader) != "undefined") {

                    //loop for each file selected for uploaded.
                    for (var i = 0; i < countFiles; i++) {

                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image"
                            }).appendTo(image_holder);
                        }

                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);
                    }

                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Pls select only images");
            }
        });
        $(document).on('submit', '#add_product', function(event) {

            event.preventDefault();
            var product_image = $("#upload11")[0]?.files;
            if (product_image.length == 0) {
                not('Product Image is required', 'error')
                return;

            }
            var title = $("#title").val()
            var category_id = $("#category_id").val()
            var quantity = $("#quantity").val()
            var price = $("#price").val()
            var detail = $("#detail").val()

            if (!title) {
                not('Title field is required', 'error');
                return;
            } else if (title.length > 30) {
                not('Description Filed must be less than 30 characters', 'error')
                return;

            } else if (!category_id) {
                not('Category Field is required.', 'error');
                return;
            } else if (!quantity) {
                not('Quantity Field is required.', 'error');
                return;
            } else if (!price) {
                not('Price Field is required.', 'error');
                return;
            } else if (!detail) {

                not('Detail Field is required.', 'error');
                return;
            } else if (detail.length > 255) {
                not('Description Filed must be less than 255 characters', 'error')
                return;

            }
            // return;
            $.ajax({
                url: "{{ url('business/save-product') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {

                        not("Product Added successfully.", 'success');
                        $('#image-holder').empty();
                        $("#add_product")[0].reset();

                        // window.location.reload()
                    } else {

                    }

                },
                error: function(jqXHR, exception) {
                    let data = JSON.parse(jqXHR.responseText);
                    not(data.message, 'error');
                }
            });
            // return;

        });

        $(document).on('click','#clear_all', function(){
            $("#upload11").val(null);
            $('#image-holder').empty();
        })



    })
</script>

@endsection
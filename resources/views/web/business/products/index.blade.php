@extends('layout.master')
@section('content')
<div class="contentBody">
    <div class="categoryWrap pb-5">
        <ul class="nav nav-pills mb-3 row catTabs" role="tablist">

            @foreach($categories->take(10) as $key=> $category)

            <li class="nav-item col-lg-3 col-md-4 col-sm-6 col-6" role="presentation">
                <button class="nav-link {{$key==0?'active':''}}" id="pills-catTab1-tab" category-id="{{$category->id}}" data-bs-toggle="pill" data-bs-target="#pills-catTab1" type="button" role="tab" aria-controls="pills-catTab1" aria-selected="{{$key==0?'true':'false'}}">{{$category->category_name}}</button>
            </li>
            @endforeach

        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-catTab1" role="tabpanel" aria-labelledby="pills-catTab1-tab">
                <div class="row pt-4 productsRow" id="product">


                </div>
            </div>

        </div>
    </div>

    <a href="{{url('business/add-product')}}" class="genBtn addnewBtn">Add New</a>
</div>

<!-- Edit Product Modal -->
<div class="modal fade editModal1" id="editproductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header xy-center">
                <h5 class="heading text-center" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="addnewForm" id="edit_product" enctype="multipart/form-data">
                    @csrf
                    <div class="currentImages" id="prd_images">

                    </div>
                    <input type="hidden" value="" id="product_id" name="product_id" />
                    <div class="form-group">
                        <input type="text" class="formInput1" name="title" id="title" onKeyPress="if(this.value.length==30) return false;" placeholder="Product Title">
                    </div>
                    <div class="uploadBox">
                        <label id="wrapper" for="upload11" class="xy-center">
                            <i class="fa-solid fa-plus"></i>
                            <input id="upload11" class="d-none" type="file" name="files[]" multiple="" accept="image/gif, image/jpeg, image/png">
                        </label>
                        <button type="button" id="clear_all" class="genBtn clearBtn">Clear All</button>
                    </div>
                    <div id="image-holder"></div>
                    <div class="form-group">
                        <select name="category_id" id="category_id" class="form-control formInput1 select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="formInput1" min="0" name="quantity" id="quantity" placeholder="Quantity">
                    </div>
                    <div class="form-group">
                        <input type="text" class="formInput1" min="0" name="price" id="price" placeholder="Price" step="any">
                    </div>
                    <div class="form-group">
                        <textarea type="text" class="formInput1 mb-0" name="detail" id="detail" placeholder="Details" onKeyPress="if(this.value.length==255) return false;" style="height: 150px; padding: 20px; resize: none; border-radius: 20px;"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="genBtn addnewBtn mw-100">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        var categories = <?php echo json_encode($categories); ?>;

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

        // CHART JS START

        var category_id = $("#pills-catTab1-tab").attr('category-id')

        $.ajax({
            url: "{{url('business/category-products')}}",
            data: {
                category_id
            },
            dataType: 'json',
            success: function(response, textStatus, jqXHR) {
                if (response.status == 1) {
                    data = response.data
                   
                    if (data.length == 0) {
                        $("#product").html(`<h1 class="text-center">Products Not Found</h1>`)
                        return;
                    };
                    $("#product").html(laodProducts(data))

                } else {
                    // toastr.error(response.message, 'error');
                }

            }
        });

        $(document).on('submit', '#edit_product', function(event) {
            event.preventDefault();
            // var product_image = $("#upload11")[0]?.files;
            // if (product_image.length == 0) {
            //     not('Product Image is required', 'error')
            //     return;

            // }
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
                url: "{{ url('business/edit-product') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {
                        prd_div.innerHTML = laodProduct(response.product);
                        images = response.data;

                        images = images.map(image => {
                            image_url = "{{url('public')}}/" + image?.image_url;
                            return `<div class="imgBox">
                            <p class="crossbtn" data-id= ${image.id}><i class="fa-solid fa-xmark"></i></p>
                            <img src="${image_url}" alt="img">
                        </div>`;
                        }).join("")
                        $('#prd_images').append(images);
                        $("#upload11").val(null);
                        $('#image-holder').empty();
                        not("Product Updated successfully.", 'success');
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


        $(document).on('click', '#pills-catTab1-tab', function() {
            var category_id = $(this).attr('category-id')
            $.ajax({
                url: "{{url('business/category-products')}}",
                data: {
                    category_id
                },
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {
                        data = response.data
                    console.log(data.length == 0 ,'data')

                        if (data.length == 0) {
                            // console.log('d')
                             $("#product").html(`<h1 class="text-center">Products Not Found</h1>`)
                             return;
                        };
                        $("#product").html(laodProducts(data))

                    } else {
                        // toastr.error(response.message, 'error');
                    }

                }
            });

        })
        
        $(document).on('click', '.crossbtn', function() {
            if (!confirm("Are You Sure, Want to Delete it.?")) {
                return;
            }
            ref = $(this);
            image_id = ref.attr('data-id')
            $.ajax({
                url: "{{url('business/delete-product-image')}}",
                data: {
                    image_id
                },
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {
                        ref.parent().remove();
                        not('Image Removed', 'success')
                        // console.log(response)
                    } else {
                        // toastr.error(response.message, 'error');
                    }

                }
            });
            // console.log(image_id)
        });
        $(document).on('click', '.dltBtn', function() {
            if (!confirm("Are You Sure, Want to Delete it.?")) {
                return;
            }
            ref = $(this);
            // console.log(ref.parents()[2].remove(),'ref')
            
            product_id = ref.attr('data-id')
            $.ajax({
                url: "{{url('business/delete-product')}}",
                data: {
                    product_id
                },
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {
                        ref.parents()[2].remove();
                        not('Product Deleted Successfully', 'success')
                        // console.log(response)
                    } else {
                        // toastr.error(response.message, 'error');
                    }

                }
            });
            // console.log(image_id)
        });
        var prd_div = "";
        $(document).on('click', '.editCard', function() {
            parent_index = $(this).attr('index-id');
            // alert('e');
            prd_div = $(this).parents()[3].children[parent_index]
            product_id = $(this).attr('data-id')
            $.ajax({
                url: "{{url('business/product')}}",
                data: {
                    product_id
                },
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {
                        $("#image-holder").html("")
                        data = response.data
                        category_id = data.category_id
                        $("#category_id option").each(function() {
                            if ($(this).val() == category_id) { // EDITED THIS LINE
                                $(this).attr("selected", "selected");
                            }
                        });
                        images = data.images
                        images = images.map(image => {
                            image_url = "{{url('public')}}/" + image?.image_url;
                            return `<div class="imgBox">
                            <p class="crossbtn" data-id= ${image.id}><i class="fa-solid fa-xmark"></i></p>
                            <img src="${image_url}" alt="img">
                        </div>`;
                        }).join("")

                        $("#prd_images").html(images)
                        $("#product_id").val(data.id);
                        $("#title").val(data.title);
                        $("#quantity").val(data.quantity);
                        $("#price").val(data.price);
                        $("#detail").val(data.detail);
                        $("#title").val(data.title);
                        $("#title").val(data.title);

                    } else {
                        // toastr.error(response.message, 'error');
                    }

                }
            });
        })


        $(document).on('click', '#clear_all', function() {
            $("#upload11").val(null);
            $('#image-holder').empty();
        })

        function laodProduct(product) {
            image_url = "{{url('public')}}/" + product?.image?.image_url;
            // console.log(image_url)
            return `
                        <div class="productCard">
                            <div class="imgbox w-100 relClass">
                                <img src="${image_url}" alt="img" class="img-fluid">
                                <p class="priceTag">Price: <span>${product.price}$</span></p>
                                <a href="#editproductModal" class="editCard xy-center" id="edit_product" data-id="${product.id}" data-bs-toggle="modal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </div>
                            <a href="#!" class="textBox d-block">
                                <div class="xy-between pb-2">
                                    <p class="heading">${product.title}</p>
                                    <p class="qty">Quantity <span>${product.quantity}</span></p>
                                </div>
                                <p class="desc">${product.detail}</p>
                            </a>
                        </div>`;

            // $("#product").html(products_html)
        }

        function laodProducts(products) {
            return products_html = products.map((product, index) => {
                // image_url = "{{url('public')}}/"+product?.image?.image_url;
                image_url = "{{url('public')}}/" + product?.image?.image_url;
                return `<div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="productCard">
                            <div class="imgbox w-100 relClass">
                                <img src="${image_url}" alt="img" class="img-fluid">
                                <p class="priceTag">Price: <span>${product.price}$</span></p>
                                <a href="#editproductModal" class="editCard xy-center" id="edit_product" index-id="${index}" data-id="${product.id}" data-bs-toggle="modal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#!" class="deleteCard dltBtn xy-center" id="delete_product" index-id="${index}" data-id="${product.id}">
                                <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                            <a href="#!" class="textBox d-block">
                                <div class="xy-between pb-2">
                                    <p class="heading">${product.title}</p>
                                    <p class="qty">Quantity <span>${product.quantity}</span></p>
                                </div>
                                <p class="desc">${product.detail}</p>
                            </a>
                        </div>
                    </div>`;
            }).join("")

            // $("#product").html(products_html)
        }

    })
</script>

@endsection
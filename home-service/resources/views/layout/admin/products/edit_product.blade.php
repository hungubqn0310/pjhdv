@extends('layout-admin')
@section('admin-content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật sản phẩm
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form enctype="multipart/form-data" id="form-update-product" method="PUT">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="productName" value="{{$edit_product['data']['product_name']}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" value="{{$edit_product['data']['product_image']}}" name="product_image" class="form-control" id="productImage">
                            <img src="{{URL::to('upload/product/'.$edit_product['data']['product_image'])}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="productDesc">{{$edit_product['data']['product_desc']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" id="categoryId" class="form-control input-sm m-bot15">
                                <option value="{{$edit_product['data']['category']['category_id']}}">{{$edit_product['data']['category']['category_name']}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" value="{{$edit_product['data']['product_price']}}" name="product_price" class="form-control" id="productPrice" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <select name="discount_id" id="discountId" class="form-control input-sm m-bot15">
                                <option value="{{$edit_product['data']['discount']['discount_id']}}">{{$edit_product['data']['discount']['discount_name']}}</option>
                            </select>
                        </div>
                        <button  name="update_product" class="btn btn-info update_product">Cập nhật</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
    <script>
    $(document).ready(function() {
        $('.update_product').on('click', function(event) {
            
            event.preventDefault();

            var form = $('#form-update-product')[0];
            var data = new FormData(form);
            data.append('product_name', $('#productName').val());
            data.append('category_id', $('#categoryId').val());
            data.append('discount_id', $('#discountId').val());
            data.append('product_desc', $('#productDesc').val());
            data.append('product_price', $('#productPrice').val());
            data.append('product_image', $('#productImage').val());
            $.ajax({
                type: "PUT",
                enctype: 'multipart/form-data',
                url: "http://localhost:8000/update-product/"+ product_id,
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    alert('Cập nhật sản phẩm thành công!')
                    window.location.href = response.redirect;
                },
                error: function (e) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
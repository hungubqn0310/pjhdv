@extends('layout-admin')
@section('admin-content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>
            <div class="panel-body">

                <div class="position-center">
                    <form enctype="multipart/form-data" id="form-add-product" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" name="product_name" class="form-control" id="productName" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="productImage">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none"  rows="8" class="form-control" name="product_desc" id="productDesc" placeholder="Mô tả sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" id="categoryId" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $category)
                                    <option value="{{$category['category_id']}}">{{$category['category_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số tiền" name="product_price" class="form-control" id="productPrice" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <select name="discount_id" id="discountId" class="form-control input-sm m-bot15">
                                @foreach($discounts as $discount)
                                    <option value="{{$discount['discount_id']}}">{{$discount['discount_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button name="add_product" type="submit" class="btn btn-info add_product">Thêm mới</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.add_product').on('click', function(event) {
            
            event.preventDefault();

            var form = $('#form-add-product')[0];
            var data = new FormData(form);
            data.append('product_name', $('#productName').val());
            data.append('category_id', $('#categoryId').val());
            data.append('discount_id', $('#discountId').val());
            data.append('product_desc', $('#productDesc').val());
            data.append('product_price', $('#productPrice').val());
            data.append('product_image', $('#productImage').val());
            data.append('product_status', $('select[name="product_status"]').val());

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "http://localhost:8000/save-product",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    alert('Thêm sản phẩm thành công!')
                },
                error: function (e) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
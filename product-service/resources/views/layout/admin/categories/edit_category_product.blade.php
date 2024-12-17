@extends('layout-admin')
@section('admin-content')
<div class="row">
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Cập nhật danh mục sản phẩm
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên danh mục</label>
                        <input type="text" value="{{$edit_category_product->category_name}}" name="category_product_name" class="form-control" id="edit-categoryName" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả danh mục</label>
                        <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc" id="edit-categoryDesc" >{{$edit_category_product->category_desc}}</textarea>
                    </div>
                    <button name="update_category_product" class="btn btn-info update-category">Cập nhật</button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('.update-category').on('click', function(e) {
            event.preventDefault();
            const data = {
                category_product_name: $('#edit-categoryName').val(),
                category_product_desc: $('#edit-categoryDesc').val(),
                _token: $('input[name="_token"]').val()
            };
            $.ajax({
                url: '{{ route("api.update-category", ["category_product_id" => $edit_category_product->category_id]) }}',
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Cập nhật danh mục sản phẩm thành công");
                    window.location.href = response.redirect;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
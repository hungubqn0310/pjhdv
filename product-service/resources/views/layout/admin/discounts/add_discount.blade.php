@extends('layout-admin')
@section('admin-content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mã giảm giá
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <form>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mã giảm giá</label>
                            <input type="text" name="discount_name" class="form-control" id="discountName">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Phần trăm giảm</label>
                            <input type="text" name="discount_percent" class="form-control" id="discountPercent">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ngày áp dụng</label>
                            <input type="date" name="start_date" class="form-control" id="startDate">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ngày hết hạn</label>
                            <input type="date" name="end_date" class="form-control" id="endDate">
                        </div>
                        <button name="add_discount" class="btn btn-info add_discount">Thêm mới</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.add_discount').on('click', function(event) {
            event.preventDefault();
            const data = {
                discount_name: $('#discountName').val(),
                discount_percent: $('#discountPercent').val(),
                start_date: $('#startDate').val(),
                end_date: $('#endDate').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{route('api.save-discount')}}",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Thêm mã giảm giá thành công!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
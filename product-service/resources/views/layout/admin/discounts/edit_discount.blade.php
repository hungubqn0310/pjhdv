@extends('layout-admin')
@section('admin-content')
<div class="row">
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Cập nhật mã giảm giá
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mã giảm giá</label>
                        <input type="text" value="{{ $edit_discount->discount_name }}" name="discount_name" class="form-control" id="edit-discountName">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Phần trăm giảm</label>
                        <input type="text" value="{{ $edit_discount -> discount_percent }}" name="discount_percent" class="form-control" id="edit-discountPercent">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Ngày áp dụng</label>
                        <input type="date" value="{{\Carbon\Carbon::parse($edit_discount->start_date)->format('Y-m-d')}}" name="start_date" class="form-control" id="edit-startDate">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Ngày hết hạn</label>
                        <input type="date" value="{{\Carbon\Carbon::parse($edit_discount->end_date)->format('Y-m-d')}}" name="end_date" class="form-control" id="edit-endDate">
                    </div>
                    <button name="update_discount" class="btn btn-info update_discount">Cập nhật</button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('.update_discount').on('click', function(e) {
            event.preventDefault();
            const data = {
                discount_name: $('#edit-discountName').val(),
                discount_percent: $('#edit-discountPercent').val(),
                start_date: $('#edit-startDate').val(),
                end_date: $('#edit-endDate').val(),
                _token: $('input[name="_token"]').val()
            };
            $.ajax({
                url: '{{ route("api.update-discount", ["discount_id" => $edit_discount->discount_id]) }}',
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert("Cập nhật mã giảm giá thành công");
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
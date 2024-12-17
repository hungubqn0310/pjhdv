@extends('layout-admin')
@section('admin-content')

<!--main content start-->
<div class="panel panel-default">
  <div class="panel-heading">
    Danh sách mã giảm giá
  </div>
  
  <div class="table-responsive">
    <table class="table table-striped b-t b-light">
      <thead>
        <tr>
          <th>Mã giảm giá</th>
          <th>Phần trăm giảm</th>
          <th>Ngày áp dụng</th>
          <th>Ngày hết hạn</th>
          <th style="width:30px;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $discounts as $discount )
          <tr>
            <td>{{ $discount -> discount_name}}</td>
            <td>{{ $discount -> discount_percent}}</td>
            <td>{{ $discount -> start_date}}</td>
            <td>{{ $discount -> end_date}}</td>
            <td>
              <a href="{{URL::to('/edit-discount/'.$discount->discount_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a href="{{URL::to('/delete-discount/'.$discount->discount_id)}}" class="active styling-edit delete-discount" data-id="{{$discount->discount_id}}" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.delete-discount').on('click', function(event) {
        event.preventDefault();
        var discountId = $(this).data('id');
        if (confirm("Bạn có chắc chắn muốn xóa mã giảm giá này không?")){
          $.ajax({
              url: "delete-discount/" + discountId,
              type: 'DELETE',
              contentType: 'application/json',
              headers: {
                'X-CSRF-TOKEN': csrfToken, 
              },
              success: function(response) {
                alert('Xóa mã giảm giá thành công');
                location.reload();
              },
              error: function(xhr, status, error) {
                console.log(xhr.responseText);
              }
          });
        }
    });
  });
</script>
@endsection
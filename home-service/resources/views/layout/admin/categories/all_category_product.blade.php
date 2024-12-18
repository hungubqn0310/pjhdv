@extends('layout-admin')
@section('admin-content')

<!--main content start-->
<div class="panel panel-default">
  <div class="panel-heading">
    Danh sách danh mục sản phẩm
  </div>
  
  <div class="table-responsive">
    <table class="table table-striped b-t b-light">
      <thead>
        <tr>
          <th>Tên danh mục</th>
          <th>Hiển thị</th>
          <th style="width:30px;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $categories['data'] as $cate_pro )
          <tr>
            <td>{{ $cate_pro['category_name'] }}</td>
            <td><span class="text-ellipsis">
              <?php
                if ($cate_pro['category_status'] ==0){
                  ?>
                    <a href="{{URL::to('/active-category-product/'.$cate_pro['category_id'])}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                  <?php
                }else{
                  ?>
                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro['category_id'])}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                  <?php
                }
              ?>
            </span></td>
            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate_pro['category_id'])}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a href="{{URL::to('/delete-category-product/'.$cate_pro['category_id'])}}" class="active styling-edit delete-category" data-id="{{$cate_pro['category_id']}}" ui-toggle-class="">
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

    $('.delete-category').on('click', function(event) {
        event.preventDefault();
        var categoryId = $(this).data('id');
        if (confirm("Bạn có chắc chắn muốn xóa danh mục này không?")){
          $.ajax({
              url: "delete-category-product/" + categoryId,
              type: 'DELETE',
              contentType: 'application/json',
              headers: {
                'X-CSRF-TOKEN': csrfToken, 
              },
              success: function(response) {
                alert('Xóa danh mục sản phẩm thành công');
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
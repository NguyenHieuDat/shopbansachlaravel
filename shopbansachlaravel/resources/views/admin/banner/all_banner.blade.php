@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê danh sách banner
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="dbTable">
          <thead>
            <tr>
              <th>Tên banner</th>
              <th>Hình ảnh</th>
              <th>Trạng thái</th>
              <th>Mô tả</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_banner as $key => $banner)
            <tr>
              <td>{{$banner->banner_name}}</td>
              <td>
                <img src="public/upload/banner/{{$banner->banner_image}}" height="150" width="420">
              </td>
              <td><span class="text-ellipsis">
                <?php
                if($banner->banner_status==0){
                    ?>
                <a href="{{URL::to('/unactive_banner/'.$banner->banner_id)}}">Không hiển thị</a>
                <?php
                }else{
                    ?>
                <a href="{{URL::to('/active_banner/'.$banner->banner_id)}}">Hiển thị</a>
                <?php    
                }
                    ?>
                </span></td>
              <td><span class="text-ellipsis">{!! $banner->banner_description !!}</span></td>
              <td>
                <a href="{{URL::to('/edit_banner/'.$banner->banner_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a href="{{URL::to('/delete_banner/'.$banner->banner_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
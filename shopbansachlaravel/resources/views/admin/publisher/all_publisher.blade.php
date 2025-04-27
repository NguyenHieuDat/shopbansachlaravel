@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê nhà xuất bản
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
              <th>Tên nhà xuất bản</th>
              <th>Mô tả</th>
              <th>Từ khóa</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_publisher as $key => $pub)
            <tr>
              <td>{{$pub->publisher_name}}</td>
              <td><span class="text-ellipsis">{!! $pub->publisher_description !!}</span></td>
              <td><span class="text-ellipsis">{{ $pub->publisher_keywords }}</span></td>
              <td>
                <a href="{{URL::to('/edit_publisher/'.$pub->publisher_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a href="{{URL::to('/delete_publisher/'.$pub->publisher_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
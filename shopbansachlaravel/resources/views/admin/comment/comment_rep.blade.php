@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Trả lời bình luận
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
                    <th>Trả lời cho</th>
                    <th>Nội dung bình luận</th>
                    <th>Sản phẩm</th>
                    <th>Ngày trả lời bình luận</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comment_rep as $key => $comm_rep)
                <tr>
                    @if ($comment)
                        <td>{{ $comment->comment_info }}</td>
                    @endif
                    <td><span class="text-ellipsis">{{$comm_rep->comment_info}}</span></td>
                    <td><a href="{{url('/chi_tiet_sach/'.$comm_rep->book->book_id)}}" target="_blank">{{$comm_rep->book->book_name}}</a></td>
                    <td>{{$comm_rep->comment_date}}</td>
                    <td>
                        <a href="{{URL::to('/delete_comment/'.$comm_rep->comment_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
  </div>

@endsection
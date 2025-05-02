@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê sách
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
              <th>Tên sách</th>
              <th>Thư viện ảnh</th>
              <th>Danh mục</th>
              <th>Tác giả</th>
              <th>Nhà xuất bản</th>
              <th>Giá gốc</th>
              <th>Giá tiền</th>
              <th>Ngôn ngữ</th>
              <th>Năm xuất bản</th>
              <th>Số trang</th>
              <th>Số lượng kho</th>
              <th>Trạng thái</th>
              <th>Hình ảnh</th>
              <th>Mô tả</th>
              <th>Từ khóa</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_book as $key => $book)
            <tr>
              <td>{{$book->book_name}}</td>
              <td><a href="{{URL::to('/add_gallery/'.$book->book_id)}}">Thêm thư viện ảnh</td>
              <td>{{$book->category_name}}</td>
              <td>{{$book->author_name}}</td>
              <td>{{$book->publisher_name}}</td>
              <td>{{number_format($book->book_cost,0,',','.')}} VND</td>
              <td>{{number_format($book->book_price,0,',','.')}} VND</td>
              <td>{{$book->book_language}}</td>
              <td>{{$book->book_year}}</td>
              <td>{{$book->book_page}}</td>
              <td>{{$book->book_quantity}}</td>
              <td><span class="text-ellipsis">  <!-- 1 là Còn, 0 là Hết -->
                <?php
                if($book->book_status==0){
                    ?>
                <a href="{{URL::to('/unactive_book/'.$book->book_id)}}">Hết</a>
                <?php
                }else{
                    ?>
                <a href="{{URL::to('/active_book/'.$book->book_id)}}">Còn</a>
                <?php    
                }
                    ?>
                </span></td>
              <td>
                <img src="public/upload/book/{{$book->book_image}}" height="150" width="120">
              </td>
              <td><span class="text-ellipsis">{!! $book->book_description !!}</span></td>
              <td><span class="text-ellipsis">{{ $book->book_keywords }}</span></td>
              <td>
                <a href="{{URL::to('/edit_book/'.$book->book_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a href="{{URL::to('/delete_book/'.$book->book_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection
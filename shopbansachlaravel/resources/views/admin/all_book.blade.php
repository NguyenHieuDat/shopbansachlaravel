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
      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
          <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
          </select>
          <button class="btn btn-sm btn-default">Apply</button>                
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên sách</th>
              <th>Danh mục</th>
              <th>Tác giả</th>
              <th>Nhà xuất bản</th>
              <th>Giá tiền</th>
              <th>Ngôn ngữ</th>
              <th>Năm xuất bản</th>
              <th>Số trang</th>
              <th>Trạng thái</th>
              <th>Hình ảnh</th>
              <th>Mô tả</th>
              <th>Quản lý</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_book as $key => $book)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$book->book_name}}</td>
              <td>{{$book->category_name}}</td>
              <td>{{$book->author_name}}</td>
              <td>{{$book->publisher_name}}</td>
              <td>{{$book->book_price}}</td>
              <td>{{$book->book_language}}</td>
              <td>{{$book->book_year}}</td>
              <td>{{$book->book_page}}</td>
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
              <td><span class="text-ellipsis">{{$book->book_description}}</span></td>
              <td>
                <a href="{{URL::to('/edit_book/'.$book->book_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a href="{{URL::to('/delete_book/'.$book->book_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          
          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>

@endsection
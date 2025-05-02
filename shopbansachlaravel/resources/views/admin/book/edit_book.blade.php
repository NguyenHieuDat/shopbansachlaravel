@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Sửa sách
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_book as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_book/'.$edit_value->book_id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên sách</label>
                            <input type="text" name="book_name" class="form-control" id="exampleInputEmail1" value="{{$edit_value->book_name}}">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="book_image" class="form-control-file">
                            <img src="{{URL::to('public/upload/book/'.$edit_value->book_image)}}" height="150" width="120">
                        </div>
                        <div class="form-group">
                            <label>Danh mục sách</label>
                            <select name="category" class="form-control input -sm m -bot15">
                                @foreach ($cate_product as $key => $cate)
                                @if($cate->category_id==$edit_value->category_id)
                                <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @else
                                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tác giả</label>
                            <select name="author" class="form-control input -sm m -bot15">
                                @foreach ($author as $key => $au)
                                @if($au->author_id==$edit_value->author_id)
                                <option selected value="{{$au->author_id}}">{{$au->author_name}}</option>
                                @else
                                <option value="{{$au->author_id}}">{{$au->author_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nhà xuất bản</label>
                            <select name="publisher" class="form-control input -sm m -bot15">
                                @foreach ($publisher as $key => $publ)
                                @if($publ->publisher_id==$edit_value->publisher_id)
                                <option selected value="{{$publ->publisher_id}}">{{$publ->publisher_name}}</option>
                                @else
                                <option value="{{$publ->publisher_id}}">{{$publ->publisher_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngôn ngữ</label>
                            <input type="text" name="book_language" class="form-control" value="{{$edit_value->book_language}}">
                        </div>
                        <div class="form-group">
                            <label>Năm xuất bản</label>
                            <input type="text" name="book_year" class="form-control" value="{{$edit_value->book_year}}">
                        </div>
                        <div class="form-group">
                            <label>Số trang</label>
                            <input type="text" name="book_page" class="form-control" value="{{$edit_value->book_page}}">
                        </div>
                        <div class="form-group">
                            <label>Số lượng kho</label>
                            <input type="text" name="book_quantity" class="form-control" value="{{$edit_value->book_quantity}}">
                        </div>
                        <div class="form-group">
                            <label>Giá gốc</label>
                            <input type="text" name="book_cost" class="form-control" value="{{$edit_value->book_cost}}">
                        </div>
                        <div class="form-group">
                            <label>Giá tiền</label>
                            <input type="text" name="book_price" class="form-control" value="{{$edit_value->book_price}}">
                        </div>
                        <div class="form-group">
                            <label>Tình trạng</label>
                            <select name="book_status" class="form-control input -sm m -bot15">
                                <option value="0">Hết</option>
                                <option value="1">Còn</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="book_description" class="form-control" id="ckeditor_book_edit">{!! $edit_value->book_description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <input type="text" name="book_keywords" class="form-control" value="{{$edit_value->book_keywords}}">
                        </div>
                        <button type="submit" name="add_book" class="btn btn-info">Sửa sách</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
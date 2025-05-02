@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sách
            </header>
            <div class="panel-body">
                <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-success'>{$message}</span>";
                    Session::put('message',null);
                }
                ?>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save_book')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên sách</label>
                            <input type="text" name="book_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên sách">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="book_image" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Danh mục sách</label>
                            <select name="category" class="form-control input -sm m -bot15">
                                @foreach ($cate_product as $key => $cate)
                                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tác giả</label>
                            <select name="author" class="form-control input -sm m -bot15">
                                @foreach ($author as $key => $au)
                                <option value="{{$au->author_id}}">{{$au->author_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nhà xuất bản</label>
                            <select name="publisher" class="form-control input -sm m -bot15">
                                @foreach ($publisher as $key => $publ)
                                <option value="{{$publ->publisher_id}}">{{$publ->publisher_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngôn ngữ</label>
                            <input type="text" name="book_language" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Năm xuất bản</label>
                            <input type="text" name="book_year" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số trang</label>
                            <input type="text" name="book_page" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số lượng kho</label>
                            <input type="text" name="book_quantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giá gốc</label>
                            <input type="text" name="book_cost" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giá tiền</label>
                            <input type="text" name="book_price" class="form-control">
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
                            <textarea type="text" style="resize: none" rows="7" name="book_description" class="form-control" id="ckeditor_book_add"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <input type="text" name="book_keywords" class="form-control">
                        </div>
                        <button type="submit" name="add_book" class="btn btn-info">Thêm sách</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
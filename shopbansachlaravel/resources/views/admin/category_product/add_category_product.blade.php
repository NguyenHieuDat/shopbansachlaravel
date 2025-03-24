@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục sách
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
                    <form role="form" action="{{URL::to('/save_category_product')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input type="text" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập danh mục sách">
                        </div>
                        <div class="form-group">
                            <label>Loại danh mục</label>
                            <select name="category_parent" class="form-control">
                                <option value="0">Danh mục cha</option>
                                @foreach($category_product as $key => $cate)
                                    <option value="{{ $cate->category_id }}">{{ $cate->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="category_product_description" class="form-control" id="ckeditor_cate_add" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <input type="text" name="category_product_keywords" class="form-control" placeholder="Nhập từ khóa">
                        </div>
                        <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
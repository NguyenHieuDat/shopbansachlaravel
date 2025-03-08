@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm tác giả
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
                    <form role="form" action="{{URL::to('/save_author')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên tác giả</label>
                            <input type="text" name="author_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên tác giả">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="author_image" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="author_description" class="form-control" id="ckeditor_author_add" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <button type="submit" name="add_author" class="btn btn-info">Thêm tác giả</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
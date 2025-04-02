@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Sửa tác giả
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_author as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_author/'.$edit_value->author_id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên tác giả</label>
                            <input type="text" value="{{$edit_value->author_name}}" name="author_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="author_image" class="form-control">
                            <img src="{{URL::to('public/upload/author/'.$edit_value->author_image)}}" height="150" width="120">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="author_description" class="form-control" id="ckeditor_author_edit">{!! $edit_value->author_description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <input type="text" value="{{$edit_value->author_keywords}}" name="author_keywords" class="form-control">
                        </div>
                        <button type="submit" name="edit_author" class="btn btn-info">Sửa tác giả</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
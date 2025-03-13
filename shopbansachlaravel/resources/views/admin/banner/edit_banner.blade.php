@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Sửa banner
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_banner as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_banner/'.$edit_value->banner_id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên tác giả</label>
                            <input type="text" value="{{$edit_value->banner_name}}" name="banner_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="banner_image" class="form-control">
                            <img src="{{URL::to('public/upload/banner/'.$edit_value->banner_image)}}" height="150" width="120">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="banner_status" class="form-control input -sm m -bot15">
                                <option value="0">Không hiển thị</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="banner_description" class="form-control" id="ckeditor_banner_edit">{!! $edit_value->banner_description !!}</textarea>
                        </div>
                        <button type="submit" name="edit_banner" class="btn btn-info">Sửa banner</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
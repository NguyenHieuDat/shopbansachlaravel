@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm banner
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
                    <form role="form" action="{{URL::to('/save_banner')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên banner</label>
                            <input type="text" name="banner_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="banner_image" class="form-control-file">
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
                            <textarea type="text" style="resize: none" rows="7" name="banner_description" class="form-control" id="ckeditor_banner_add"></textarea>
                        </div>
                        <button type="submit" name="add_banner" class="btn btn-info">Thêm banner</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
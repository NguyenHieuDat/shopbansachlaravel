@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm nhà xuất bản
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
                    <form role="form" action="{{URL::to('/save_publisher')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên nhà xuất bản</label>
                            <input type="text" name="publisher_name" class="form-control" placeholder="Nhập tên nhà xuất bản">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="publisher_description" class="form-control" id="ckeditor_pub_add" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <input type="text" name="publisher_keywords" class="form-control" placeholder="Nhập từ khóa">
                        </div>
                        <button type="submit" name="add_publisher" class="btn btn-info">Thêm nhà xuất bản</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Sửa nhà xuất bản
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_publisher as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_publisher/'.$edit_value->publisher_id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên nhà xuất bản</label>
                            <input type="text" value="{{$edit_value->publisher_name}}" name="publisher_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="publisher_description" class="form-control" id="exampleInputPassword1">{{$edit_value->publisher_description}}</textarea>
                        </div>
                        <button type="submit" name="edit_publisher" class="btn btn-info">Sửa nhà xuất bản</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
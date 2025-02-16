@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Sửa danh mục sách
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_category_product as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_category_product/'.$edit_value->category_id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="category_product_description" class="form-control" id="exampleInputPassword1">{{$edit_value->category_description}}</textarea>
                        </div>
                        <button type="submit" name="edit_category_product" class="btn btn-info">Sửa danh mục</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
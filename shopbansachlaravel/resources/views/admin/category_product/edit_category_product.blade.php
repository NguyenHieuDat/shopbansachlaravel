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
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update_category_product/'.$edit_category_product->category_id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_category_product->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="category_parent">Loại danh mục</label>
                            <select name="category_parent" class="form-control">
                                <option value="0">Danh mục cha</option>
                                @foreach ($all_category_product as $cate)
                                    @if($cate->category_parent==0)
                                        <option value="{{ $cate->category_id }}"
                                            {{ $edit_category_product->category_id == $cate->category_id ? 'selected' : '' }}>
                                            {{ $cate->category_name }}
                                        </option>
                                    
                                    @foreach ($all_category_product as $cate2)
                                        @if($cate2->category_parent == $cate->category_id)
                                        <option value="{{ $cate2->category_id }}"
                                            {{ $edit_category_product->category_id == $cate2->category_id ? 'selected' : '' }}>
                                            ---{{ $cate2->category_name }}
                                        </option>
                                        @endif
                                    @endforeach
                                    @endif  
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea type="text" style="resize: none" rows="7" name="category_product_description" class="form-control" id="ckeditor_cate_edit">{!! $edit_category_product->category_description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Từ khóa</label>
                            <input type="text" value="{{$edit_category_product->category_keywords}}" name="category_product_keywords" class="form-control" id="exampleInputEmail1">
                        </div>
                        <button type="submit" name="edit_category_product" class="btn btn-info">Sửa danh mục</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

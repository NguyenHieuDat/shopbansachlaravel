@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê danh mục sách
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
          <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
          </select>
          <button class="btn btn-sm btn-default">Apply</button>                
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên danh mục</th>
              <th>Thuộc danh mục</th>
              <th>Mô tả</th>
              <th>Từ khóa</th>
              <th>Quản lý</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_category_product as $key => $cate_pro)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$cate_pro->category_name}}</td>
              <td>
                @if($cate_pro->category_parent==0)
                  <span>Danh mục cha</span>
                @else
                  @foreach ($category_product as $key => $sub_cate)
                      @if($sub_cate->category_id==$cate_pro->category_parent)
                        <span>{{$sub_cate->category_name}}</span>
                      @endif
                  @endforeach
                @endif
              </td>
              <td><span class="text-ellipsis">{!! $cate_pro->category_description !!}</span></td>
              <td><span class="text-ellipsis">{{$cate_pro->category_keywords}}</span></td>
              <td>
                <a href="{{URL::to('/edit_category_product/'.$cate_pro->category_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a href="{{URL::to('/delete_category_product/'.$cate_pro->category_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          
          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {{ $all_category_product->firstItem() }} - {{ $all_category_product->lastItem() }} của {{ $all_category_product->total() }} mục</small>
          </div>

          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li class="page-item {{ $all_category_product->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $all_category_product->previousPageUrl() }}" @if($all_category_product->onFirstPage()) class="disabled" @endif>« Prev</a>
              </li>
              @foreach ($all_category_product->getUrlRange(1, $all_category_product->lastPage()) as $page => $url)
                  <li class="page-item {{ ($page == $all_category_product->currentPage()) ? 'active' : '' }}">
                      <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                  </li>
              @endforeach
              <li class="page-item {{ $all_category_product->hasMorePages() ? '' : 'disabled' }}">
                  <a class="page-link" href="{{ $all_category_product->nextPageUrl() }}" @if(!$all_category_product->hasMorePages()) class="disabled" @endif>Next »</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>

@endsection
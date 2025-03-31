@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê bình luận
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="dbTable">
          <thead>
            <tr>
                <th>Trạng thái</th>
                <th>Tên người gửi</th>
                <th>Nội dung bình luận</th>
                <th>Trả lời bình luận</th>
                <th>Sản phẩm</th>
                <th>Ngày gửi bình luận</th>
                <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($comment as $key => $comm)
            <tr>
                <td>
                    @if($comm->comment_status == 1)
                        <input type="button" data-comment_status="0" data-comment_id="{{$comm->comment_id}}" 
                        id="{{$comm->comment_book_id}}" class="btn btn-danger btn-sm duyet_comment_btn" value="Bỏ duyệt">
                    @elseif($comm->comment_status == 0)
                        <input type="button" data-comment_status="1" data-comment_id="{{$comm->comment_id}}" 
                        id="{{$comm->comment_book_id}}" class="btn btn-success btn-sm duyet_comment_btn" value="Duyệt">
                    @endif
                </td>
                <td>{{$comm->comment_name}}</td>
                <td><span class="text-ellipsis">{{$comm->comment_info}}</span>
                    @if($comm->comment_status == 1)
                        <br><textarea rows="1" class="form-control reply_comment_{{$comm->comment_id}}" style="width: 100%;"></textarea>
                        <button class="btn btn-default btn-sm reply_comment_btn" data-comment_id="{{$comm->comment_id}}" 
                        data-book_id="{{$comm->comment_book_id}}">Trả lời bình luận</button>
                    @endif
                </td>
                <td>
                  <ul> Trả lời: 
                    @foreach ($comment_rep as $key => $comm_rep)
                      @if($comm_rep->comment_parent_comment == $comm->comment_id)
                        <li style="color: blue; margin:5px 20px"><a href="{{url('/list_reply_comment/'.$comm->comment_id)}}">{{$comm_rep->comment_info}}</a></li>
                      @endif
                    @endforeach
                  </ul>
                </td>
                <td><a href="{{url('/chi_tiet_sach/'.$comm->book->book_id)}}" target="_blank">{{$comm->book->book_name}}</a></td>
                <td>{{$comm->comment_date}}</td>
                <td>
                  <a href="{{URL::to('/delete_comment/'.$comm->comment_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- <footer class="panel-footer">
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
      </footer> --}}
    </div>
  </div>

@endsection
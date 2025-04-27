@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê người dùng
    </div>
      <?php
        $message = Session::get('message');
        if($message){
            echo '<span class="text-success">'.$message.'</span>';
            Session::put('message',null);
        }
      ?>
      @if(session()->has('error'))
        <span class="text-error">
          {{ session('error') }}
        </span>
      @endif
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="dbTable">
        <thead>
          <tr>
            <th>Tên người dùng</th>
            <th>Địa chỉ Email</th>
            <th>Số điện thoại</th>
            <th>Mật khẩu</th>
            <th>Admin</th>
            <th>User</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($admin as $key => $user)
            <form action="{{url('/assign_roles')}}" method="POST">
              @csrf
              <tr>
                <td>{{ $user->admin_name }}</td>
                <td>{{ $user->admin_email }} <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                  <input type="hidden" name="admin_id" value="{{ $user->admin_id }}"></td>
                <td>{{ $user->admin_phone }}</td>
                <td>{{ \Illuminate\Support\Str::limit($user->admin_password, 15, '...') }}</td>
                <td><input type="checkbox" name="admin_role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td>
              <td>  
                <p><input type="submit" value="Phân quyền" class="btn btn-sm btn-default"></p>
                <p><a class="btn btn-sm btn-danger" style="margin:10px 0;" href="{{url('/delete_user_roles/'.$user->admin_id)}}">Xóa người dùng</a></p>
                @if(Auth::user()->canImpersonate())
                    <p><a class="btn btn-sm btn-success" style="margin:10px 0;" href="{{ route('impersonate', $user->admin_id) }}">Mạo danh người dùng</a></p>
                @endif
              </td>
              </tr>
            </form>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {{ $admin->firstItem() }} - {{ $admin->lastItem() }} của {{ $admin->total() }} mục</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li class="page-item {{ $admin->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $admin->previousPageUrl() }}" @if($admin->onFirstPage()) class="disabled" @endif>« Prev</a>
          </li>
          @foreach ($admin->getUrlRange(1, $admin->lastPage()) as $page => $url)
              <li class="page-item {{ ($page == $admin->currentPage()) ? 'active' : '' }}">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
          @endforeach
          <li class="page-item {{ $admin->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $admin->nextPageUrl() }}" @if(!$admin->hasMorePages()) class="disabled" @endif>Next »</a>
          </li>
          </ul>
        </div>
      </div>
    </footer> --}}
  </div>
</div>
@endsection
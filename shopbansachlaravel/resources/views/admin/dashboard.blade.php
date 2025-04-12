@extends('admin_layout')
@section('admin_content')
@if(session('message'))
    <span class="text-success">
        {{ session('message') }}
    </span>
@endif
@if(session('error'))
    <span class="text-error">
        {{ session('error') }}
    </span>
@endif
<div class="row">
    <h2 class="thong_ke_title">Thống kê doanh số đơn hàng</h2>
    <form class="form-row align-items-end mb-4 justify-content-center" autocomplete="off">
        @csrf
        <div class="form-group col-md-2">
            <label for="datepicker_from">Từ ngày:</label>
            <input type="text" id="datepicker_from" class="form-control">
        </div>
        <div class="form-group col-md-2">
            <label for="datepicker_to">Đến ngày:</label>
            <input type="text" id="datepicker_to" class="form-control">
        </div>
        <div class="form-group col-md-2">
            
            <input type="button" id="btn-dashboard-filter" class="btn btn-primary" value="Lọc">
        </div>
        <div class="form-group col-md-3">
            <label for="filter_time">Lọc theo:</label>
            <select class="form-control" id="">
                <option>--Chọn--</option>
                <option>Một tuần</option>
                <option>Tháng trước</option>
                <option>Tháng này</option>
                <option>Một năm</option>
            </select>
        </div>
    </form>
    <div class="col-md-12">
        <div id="orderchart" class="chart" style="height: 250px;">

        </div>
    </div>
</div>

@endsection
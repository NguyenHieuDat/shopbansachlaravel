<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
{{-- <link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/> --}}
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}">
<!-- //calendar -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<!-- //font-awesome icons -->
{{-- <script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script> --}}
{{-- <script src="{{asset('public/backend/js/raphael-min.js')}}"></script> --}}
{{-- <script src="{{asset('public/backend/js/morris.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		load_gallery();
		function load_gallery(){
			var gal_id = $('.gal_id').val();
			var _token = $('input[name="_token"]').val();
		$.ajax({
			url:"{{url('/select_gallery')}}",
			method:"POST",
			data:{gal_id:gal_id,_token:_token},
			success:function(data){
				$('#gallery_load').html(data);
			}
		});
		}

		$('#file').change(function(){
			var error = '';
			var files = $('#file')[0].files;
			$('#error_gallery').html('');
			if(files.length>5){
				error+='<p>Chỉ được chọn tối đa 5 ảnh!</p>';
			}else if(files.length == 0){
				error+='<p>Không được bỏ trống ảnh!</p>';
			}
			var totalSize = 0;
    		for (var i = 0; i < files.length; i++) {
        	totalSize += files[i].size; // Tính tổng kích thước của các tệp
    		}
    		if (totalSize > 10000000) { // 10 MB = 10,000,000 bytes
        		error += '<p>Ảnh không được lớn hơn 10 MB!</p>';
    		}
			if(error==''){

			}else{
				$('#file').val('');
				$('#error_gallery').html('<span class="text-alert">'+error+'</span>');
				return false;
			}
		});

		$(document).on('blur','.edit_gal_name',function(){
			var gal_id = $(this).data('gal_id');
			var gal_text = $(this).text();
			var _token = $('input[name="_token"]').val();
			$.ajax({
			url:"{{url('/update_gallery_name')}}",
			method:"POST",
			data:{gal_id:gal_id,gal_text:gal_text,_token:_token},
			success:function(data){
				load_gallery();
				$('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công!</span>');
			}
		});
		});

		$(document).on('click','.delete_gallery',function(){
			var gal_id = $(this).data('gal_id');
			var _token = $('input[name="_token"]').val();
			if(confirm('Bạn chắc chắn muốn xóa chứ?')){
				$.ajax({
				url:"{{url('/delete_gallery')}}",
				method:"POST",
				data:{gal_id:gal_id,_token:_token},
				success:function(data){
					load_gallery();
					$('#error_gallery').html('<span class="text-success">Xóa hình ảnh thành công!</span>');
				}
			});
			}
		});

		$(document).on('change','.file_image',function(){
			var gal_id = $(this).data('gal_id');
			var image = document.getElementById('file-'+gal_id).files[0];
			var form_data = new FormData();
			form_data.append("file",document.getElementById('file-'+gal_id).files[0]);
			form_data.append("gal_id",gal_id);
			$.ajax({
				url:"{{url('/update_gallery')}}",
				method:"POST",
				headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					load_gallery();
					$('#error_gallery').html('<span class="text-success">Cập nhật hình ảnh thành công!</span>');
				}
			});
		});
	});
</script>
<script type="text/javascript">
	fetch_delivery();
	function fetch_delivery(){
		var _token = $('input[name="_token"]').val();
		$.ajaxSetup({
    	headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
	});
		$.ajax({
			url: "{{url('/select_feeship')}}",
				type: "POST",
				data: {_token: _token},
				success:function(data){
					$('#load_delivery').html(data);
				}
		});
	}
	$(document).ready(function(){
		$('.add_delivery').click(function(){
			var city = $('.city').val();
			var province = $('.province').val();
			var ward = $('.ward').val();
			var feeship = $('.fee_ship').val();
			var _token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
				url: "{{url('/insert_delivery')}}",
				type: 'POST',
				data: { city: city, province: province,ward: ward,feeship: feeship, _token: _token },
				success: function(response) {
					fetch_delivery();
				}
			});
		});

		$('.choose').on('change', function() {
			var action = $(this).attr('id');
			var maid = $(this).val();
			var _token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
				url: "{{url('/select_delivery')}}",
				type: 'POST',
				data: { action: action, maid: maid, _token: _token },
				dataType: 'json',
				success: function(response) {
					var result = (action == 'city') ? 'province' : 'ward';
					$('#' + result).html(response.output);
				},
				error: function(xhr) {
					console.log("Lỗi Ajax:", xhr.responseText);
				}
			});
		});
	});

	$(document).on('blur','.feeship_edit',function(){
		var feeship_id = $(this).data('feeship_id');
		var fee_price = $(this).text();
		var _token = $('meta[name="csrf-token"]').attr('content');

		var fee_value = fee_price.replace('.', '');
		fee_value = fee_value.replace(/\s?đ$/, '');
		$.ajaxSetup({
    	headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
				url: "{{url('/update_delivery')}}",
				type: "POST",
				data: {feeship_id:feeship_id, fee_value:fee_value, _token:_token},
				success: function(data) {
					fetch_delivery();
				}
			});
	});
</script>
<script type="text/javascript">
	$(function() {
      $("#datepicker_from").datepicker({
		dateFormat:"yy-mm-dd",
	  });
    });

	$(function() {
      $("#datepicker_to").datepicker({
		dateFormat:"yy-mm-dd",
	  });
    });

	$(function() {
      $("#coupon_date_start").datepicker({
		dateFormat:"yy-mm-dd",
	  });
    });

	$(function() {
      $("#coupon_date_end").datepicker({
		dateFormat:"yy-mm-dd",
	  });
    });
</script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="{{URL::to('/dashboard')}}" class="logo">
        ADMIN
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="">
                <span class="username">
					{{ Auth::user()->admin_name ?? 'Tài khoản khách' }}
				</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Hồ sơ</a></li>
                <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sách</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_category_product')}}">Thêm danh mục</a></li>
						<li><a href="{{URL::to('/all_category_product')}}">Liệt kê danh mục</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Tác giả</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_author')}}">Thêm tác giả</a></li>
						<li><a href="{{URL::to('/all_author')}}">Liệt kê tác giả</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Nhà xuất bản</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_publisher')}}">Thêm nhà xuất bản</a></li>
						<li><a href="{{URL::to('/all_publisher')}}">Liệt kê nhà xuất bản</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sách</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_book')}}">Thêm sách</a></li>
						<li><a href="{{URL::to('/all_book')}}">Liệt kê sách</a></li>
                    </ul>
                </li>
                
				<li>
                    <a href="{{URL::to('/all_order')}}">
                        <i class="fa fa-book"></i>
                        <span>Quản lý đơn đặt hàng</span>
                    </a>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_coupon')}}">Thêm mã giảm giá</a></li>
						<li><a href="{{URL::to('/all_coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý phí vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/delivery')}}">Thêm phí vận chuyển</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý banner</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_banner')}}">Thêm banner</a></li>
						<li><a href="{{URL::to('/all_banner')}}">Liệt kê banner</a></li>
                    </ul>
                </li>

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý bình luận</span>
                    </a>
                    <ul class="sub">
						
						<li><a href="{{URL::to('/list_comment')}}">Liệt kê bình luận</a></li>
                    </ul>
                </li>

				@hasrole('admin')
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý user</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add_users')}}">Thêm user</a></li>
						<li><a href="{{URL::to('/users')}}">Liệt kê user</a></li>
                    </ul>
                </li>
				@endhasrole

				@impersonate
				@if(session()->has('impersonate'))
				<li>
                    <a href="{{ route('stop_impersonate') }}">
                        <i class="fa fa-book"></i>
                        <span>Dừng mạo danh</span>
                    </a>
                </li>
				@endif
				@endimpersonate

				
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		@yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

{{-- <script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script> --}}
	{{-- <!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar --> --}}
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>

<script>
    CKEDITOR.replace('ckeditor_author_add');
    CKEDITOR.replace('ckeditor_author_edit');
    CKEDITOR.replace('ckeditor_book_add');
    CKEDITOR.replace('ckeditor_book_edit');
    CKEDITOR.replace('ckeditor_cate_add');
    CKEDITOR.replace('ckeditor_cate_edit');
    CKEDITOR.replace('ckeditor_pub_add');
    CKEDITOR.replace('ckeditor_pub_edit');
	CKEDITOR.replace('ckeditor_banner_add');
    CKEDITOR.replace('ckeditor_banner_edit');

</script>
<script type="text/javascript">
	$('.order_detail_status').change(function(){
		var order_status = $(this).val();
		var order_id = $(this).children(":selected").attr("id");
		var _token = $('meta[name="csrf-token"]').attr('content');

		quantity = [];
		$("input[name='book_sales_qty']").each(function(){
			quantity.push($(this).val());
		});
		order_book_id = [];
		$("input[name='order_book_id']").each(function(){
			order_book_id.push($(this).val());
		});
		j = 0;
		for(i=0;i<order_book_id.length;i++){
			var order_qty = $('.order_qty_'+order_book_id[i]).val();
			var order_storage_qty = $('.order_storage_qty_'+order_book_id[i]).val();
			if(parseInt(order_qty) > parseInt(order_storage_qty)){
				j = j + 1;
				if(j === 1){
					alert('Số lượng trong kho không đủ');
				}
				$('.colormark_qty_'+order_book_id[i]).css('background','#FF0000');
			} else {
				$('.colormark_qty_' + order_book_id[i]).css('background', ''); // Reset màu nếu hợp lệ
			}
		}
		if(j === 0){
			$.ajax({
				url:"{{url('/update_order_quantity')}}",
				method:"POST",
				data:{_token:_token, order_status:order_status, 
					order_id:order_id, quantity:quantity, 
					order_book_id:order_book_id},
				success:function(data){
					alert('Cập nhật trạng thái thành công');
					location.reload();
				}
			});
		}

	});

	$('.update_quantity_order').click(function(){
		var order_book_id = $(this).data('book_id');
		var order_qty = $('.order_qty_'+order_book_id).val();
		var order_sale_id = $('.order_sale_id').val();
		var _token = $('meta[name="csrf-token"]').attr('content');

		$.ajax({
			url:"{{url('/update_qty')}}",
			method:"POST",
			data:{_token:_token, order_book_id:order_book_id, 
				order_qty:order_qty, order_sale_id:order_sale_id
			},
			success:function(data){
				alert('Cập nhật số lượng thành công');
				location.reload();
			}
		});
	});

	document.querySelectorAll('.page-item.disabled a').forEach(function(link) {
    	link.addEventListener('click', function(event) {
        	event.preventDefault();
    	});
	});
</script>
<script>
	$(document).ready(function () {
		let table = new DataTable("#dbTable", {
			"language": {
				"search": "Tìm kiếm:",
				"zeroRecords": "Không tìm thấy kết quả phù hợp",
				"lengthMenu": "Hiển thị _MENU_ mục",
				"info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
				"infoEmpty": "Không có dữ liệu",
				"infoFiltered": "(lọc từ tổng _MAX_ mục)",
				"paginate": {
					"first": "<<",
					"last": ">>",
					"next": ">",
					"previous": "<"
				}
			},
			"paging": true,
			"searching": true
		});
	});
</script>
<script>
	$('.duyet_comment_btn').click(function(){
		var comment_status = $(this).data('comment_status');
		var comment_id = $(this).data('comment_id');
		var comment_book_id = $(this).attr('id');
		if(comment_status == 1){
			var alertmes = 'Duyệt thành công!';
		}else{
			var alertmes = 'Bỏ duyệt thành công!';
		}

		$.ajax({
			url:"{{url('/allow_comment')}}",
			method:"POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{comment_status:comment_status, comment_id:comment_id, 
				comment_book_id:comment_book_id
			},
			success:function(data){
				alert(alertmes);
				location.reload();
			}
		});
	});

	$('.reply_comment_btn').click(function(){
		var comment_id = $(this).data('comment_id');
		var comment = $('.reply_comment_'+comment_id).val();
		var comment_book_id = $(this).data('book_id');

		$.ajax({
			url:"{{url('/reply_comment')}}",
			method:"POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{comment:comment, comment_id:comment_id, 
				comment_book_id:comment_book_id
			},
			success:function(data){
				alert('Trả lời bình luận thành công!');
				location.reload();
			}
		});
	});
</script>
<script>
$(document).ready(function(){
	$('#btn-dashboard-filter').click(function(){
		var from_date = $('#datepicker_from').val();
		var to_date = $('#datepicker_to').val();
		var _token = $('meta[name="csrf-token"]').attr('content');
		
		$.ajax({
			url : "{{url('/date_filter')}}",
			method : "POST",
			dataType : "JSON",
			data : {
				from_date:from_date, to_date:to_date, _token:_token
			},
			success:function(data){
				chart.setData(data);
			}
		});
	});

	var chart = new Morris.Area({

		element: 'orderchart',
		lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
		parseTime: false,
		hideHover: 'auto',

		xkey: 'period',
		ykeys: ['order','sales','profit','quantity'],
		labels: ['đơn hàng','doanh số','lợi nhuận','số lượng'],
		data: [],
	});

	$('.dashboard-filter').change(function(){
		var dashboard_value = $(this).val();
		var _token = $('meta[name="csrf-token"]').attr('content');

		$.ajax({
			url : "{{url('/dashboard_filter')}}",
			method : "POST",
			dataType : "JSON",
			data : {
				dashboard_value:dashboard_value, _token:_token
			},
			success:function(data){
				chart.setData(data);
			}
		});
	});
});
</script>
</body>
</html>
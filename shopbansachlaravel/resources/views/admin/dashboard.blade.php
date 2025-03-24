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
<h3>hello</h3>
<h2>how are you</h2>

@endsection
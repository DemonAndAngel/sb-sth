@extends('layout')
@section('content')
    <post-detail :post_data="{{ $post_data }}" :is_edit="{{ $is_edit }}"></post-detail>
@endsection
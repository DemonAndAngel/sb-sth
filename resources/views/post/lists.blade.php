@extends('layout')
@section('content')
    <post-list :is_self="{{ $is_self }}"></post-list>
@endsection
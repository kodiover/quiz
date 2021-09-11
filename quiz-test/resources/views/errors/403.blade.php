@extends('errors::illustrated-layout')

@section('code', '403')
@section('title', __('Forbidden'))

@section('image')
<div style="background-image: url({{ asset('images/403.jpg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __($exception->getMessage() ?: __('Sorry, you are forbidden from accessing this page.')))

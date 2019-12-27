@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/adminStyles.css">
@endsection

@section('scripts')
<script src="/js/api/navDropdown.js"></script>
<script>
@if(session()->has('success'))
    alert('{{ session('success') }}');
@endif
</script>
@endsection

@section('content')
<h1 class="info @if(!$errors->any()) mt-80px @endif"><span class="common">Goşmak</span></h1>
    <div class="container">
        <form action="{{ route('types.store') }}" class="form-wrapper remove-all-flex" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-container">
                <label for="">Görnüşiň ady</label>
                <input type="text" name="name">
            </div>

            @error('name')
                <ul>
                    <li> {{ $message }} </li>
                </ul>
            @enderror

            <input type="submit" value="Ugrat">
        </form>
    </div>
@stop

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
<div class="container pb-0">
    <form action="{{ route('plans.store') }}" class="form-wrapper remove-all-flex" method="POST">
        @csrf
        <div class="input-container">
            <label for="plan-name">Nyrhyň ady</label>
            <input type="text" name="name" id="plan-name">
        </div>

        @error('name')
            <ul>
                <li> {{ $message }} </li>
            </ul>
        @enderror

        <input type="submit" value="Ugrat">
    </form>
</div>
<h1 class="info"><span class="common">Nyrhlar</span></h1>
<div class="container">
    <div class="form-wrapper">
        <div class="input-container remove-all-flex">
            @if(count($plans) > 0)
                @foreach($plans as $plan)
                    <input type="text" value="{{ $plan->name }}">
                    <button class="btn btn-sm" @click="changeVPS($event, {{ $plan->id }})">Üýtget</button>
                    <button class="btn btn-sm" @click="deleteVPS($event, {{ $plan->id }})">Poz</button>
                    <div class="clearfix"></div>
                @endforeach
            @else
                <h1>Hiç hili plan goşulmadyk</h1>
            @endif
        </div>
    </div>
</div>
@stop

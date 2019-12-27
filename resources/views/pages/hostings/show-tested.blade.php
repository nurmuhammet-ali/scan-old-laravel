@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/adminStyles.css">
@endsection

@section('scripts')
<script src="/js/api/jquery.js"></script>
<script src="/js/api/navDropdown.js"></script>
<script>
@if(session()->has('success'))
    alert('{{ session('success') }}');
@endif
</script>
@endsection

@section('content')
@if($test)
<h1 class="info {{ (! $errors->any()) ? 'mt-80px' : ''}}"><span class="common">{{ $hosting->company_name }} saýtynyň testi</span></h1>
<div class="h-4"></div>
    
<div class="container">
    <div class="form-wrapper" style="text-transform: uppercase;">
        <div class="input-container">
            <label for="">Title: </label>
            <p style="color: #4DC3FA;">{{ $test->title }}</p>
        </div>

        <div class="input-container">
            <label for="">CMS:</label>
            <p style="color: #4DC3FA;">{{ ($test->cms == 0) ? 'Bilinmedi' : $test->cms}}</p>
        </div>
        

        <div class="input-container">
            <label for="">URL:</label>
            <p style="color: #4DC3FA;">{{ $test->url }}</p>
        </div>
        

        <div class="input-container">
            <label for="">HTTP_CODE:</label>
            <p style="color: #4DC3FA;">{{ $test->http_code }}</p>
        </div>
        

        <div class="input-container">
            <label for="">TOTAL_TIME:</label>
            <p style="color: #4DC3FA;">{{ $test->total_time }}</p>
        </div>
        

        <div class="input-container">
            <label for="">NAMELOOKUP_TIME:</label>
            <p style="color: #4DC3FA;">{{ $test->namelookup_time }}</p>
        </div>
        

        <div class="input-container">
            <label for="">connect_time:</label>
            <p style="color: #4DC3FA;">{{ $test->connect_time }}</p>
        </div>
        

        <div class="input-container">
            <label for="">pretransfer_time:</label>
            <p style="color: #4DC3FA;">{{ $test->pretransfer_time }}</p>
        </div>
        

        <div class="input-container">
            <label for="">size_download:</label>
            <p style="color: #4DC3FA;">{{ $test->size_download }}</p>
        </div>
        

        <div class="input-container">
            <label for="">speed_download:</label>
            <p style="color: #4DC3FA;">{{ $test->speed_download }}</p>
        </div>
        

        <div class="input-container">
            <label for="">starttransfer_time:</label>
            <p style="color: #4DC3FA;">{{ $test->starttransfer_time }}</p>
        </div>
        

        <div class="input-container">
            <label for="">primary_ip:</label>
            <p style="color: #4DC3FA;">{{ $test->primary_ip }}</p>
        </div>
        

        <div class="input-container">
            <label for="">certinfo:</label>
            @if($test->certinfo)
                @php
                    $certs = explode('|', $test->certinfo);
                @endphp
                <p style="color: #4DC3FA;">About site: {{ $certs[0] }}</p>
                <p style="color: #4DC3FA;">About certificate: {{ $certs[1] }}</p>
                <p style="color: #4DC3FA;">Encryption: {{ $certs[4] .' & '. $certs[5] }}</p>
            @else
                SSL Sertifikaty ýok
            @endif
        </div>
        

        <div class="input-container">
            <label for="">primary_port:</label>
            <p style="color: #4DC3FA;">{{ $test->primary_port }}</p>
        </div>
        

        <div class="input-container">
            <label for="">local_ip:</label>
            <p style="color: #4DC3FA;">{{ $test->local_ip }}</p>
        </div>
        

        <div class="input-container">
            <label for="">local_port:</label>
            <p style="color: #4DC3FA;">{{ $test->local_port }}</p>
        </div>
        

        <div class="input-container">
            <label for="">server:</label>
            <p style="color: #4DC3FA;">{{ $test->server }}</p>
        </div>
        

        <div class="input-container">
            <label for="">date:</label>
            <p style="color: #4DC3FA;">{{ $test->date }}</p>
        </div>
        

        <div class="input-container">
            <label for="">x_powered_by:</label>
            <p style="color: #4DC3FA;">{{ $test->x_powered_by }}</p>
        </div>
        

        <div class="input-container">
            <label for="">expires</label>
            <p style="color: #4DC3FA;"> {{ $test->expires }}</p>
        </div>
        

        <div class="input-container">
            <label for="">created_at</label>
            <p style="color: #4DC3FA;"> {{ (new \Carbon\Carbon($test->created_at))->format('H:i, d.m.Y') }}</p>
        </div>
        

        <div class="input-container">
            <label for="">updated_at</label>
            <p style="color: #4DC3FA;"> {{ (new \Carbon\Carbon($test->updated_at))->format('H:i, d.m.Y') }}</p>
        </div>
        

    </div>
</div>
@else
    <h1 class="mt-80px">Bu hosting test edilmedi</h1>
@endif

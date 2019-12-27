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
<h1 class="info {{ (! $errors->any()) ? 'mt-80px' : ''}}"><span class="common">Hemmesi: Web sahypalar we VPSlar</span></h1>
<a href="{{ route('hostings.create') }}" class="add-link">
    <img width="17" height="17" src="/img/add.png"><span>Goşmak</span>
</a>
<div class="h-4"></div>
@if(count($hostings) > 0)
    <table class="container" id="table">
    <thead>
        <tr>
            <th><h1>Edaraň ady</h1></th>
            <th><h1>Web sahypa / VPS №</h1></th>
            <th><h1>Habarlaşmak üçin telefon belgileri</h1></th>
            <th><h1>Edaranyň haty we senesi</h1></th>
            <!-- <th><h1>Ýolbaşçynyň A.A.F</h1></th> -->
            <th><h1>Jogapkär işgärleri</h1></th>
            <!-- <th><h1>Şertnama baglanşan senesi</h1></th> -->
            <th><h1>Tarif</h1></th>
            {{-- <th><h1>Gornushi</h1></th> --}}
            <th style="width: 50px;"></th>
            {{-- <th><h1>Bellik</h1></th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($hostings as $hosting)
            <tr>
                <td>{{ $hosting->company_name }}</td>
                <td class="align">{{ $loop->iteration }}</td>
                <td>{{ $hosting->phone_number }}</td>
                <td>
                    №{{ $hosting->letter_number }}  
                    {{ (new \Carbon\Carbon($hosting->letter_at))->format('d.m.Y') }}
                </td>
                <td>{{ $hosting->responsible_employee_name }}</td>
                <td>{{ $hosting->plan()->name }} {{ $hosting->plan()->created_at->format('d.m.Y') }}</td>
                <td class="actions">
                    <a href="{{ route('hostings.show', ['hosting' => $hosting->id]) }}">
                        <img src="/img/edit.png" alt="" width="16" height="16">
                    </a>
                    <a href="{{ route('hostings_checked.show', ['hosting' => $hosting->id]) }}" title="Testi gör">
                        <img src="/img/eye.png" alt="" width="16" height="16">
                    </a>
                    <a href="#">
                        <form action="{{ route('hostings.destroy', ['hosting' => $hosting->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <img src="/img/delete.png" alt="" width="16" height="16" onclick="this.parentNode.submit();">
                        </form>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <h1>Hiç hili hosting akkount ýok</h1>
@endif
@stop

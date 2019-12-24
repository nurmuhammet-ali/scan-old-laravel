@extends('layouts.app')

@section('content')
    <h1>Hello</h1>
    
    @foreach($results as $result)
        <ul>
            <li>{{ $result->hosting->domain_name }}</li>
            <li>{{ $result->http_code }}</li>
            <li>{{ $result->total_time }}</li>
            <li>{{ $result->primary_ip }}</li>
        </ul>
    @endforeach
@stop

@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/adminStyles.css">
<link rel="stylesheet" href="/css/change.css">
@endsection

@section('scripts')
    <script src="/js/api/sortRedGreen.js"></script>
    <script src="/js/api/countSites.js"></script>
    <script src="/js/api/sortBySite.js"></script>
    <script src="/js/api/sortByIp.js"></script>
    <script src="/js/api/sortByError.js"></script>
    <script src="/js/api/sortByEngine.js"></script>
    <script src="/js/api/sortByTime.js"> </script>
    <script src="/js/api/sortByCode.js"></script>
    <script src="/js/api/sortByDate.js"></script>
    <script src="/js/api/jquery.js"></script>
    <script src="/js/api/navDropdown.js"></script>
@endsection

@section('content')
<div id="app">
    <h1 class="mt-80px">Üýtgeşmeler</h1>
    <div class="changes-container">
        @foreach($changes as $change)
        <table class="new-table-container" id="">
            <thead>
                <tr>
                    <th colspan="3">{{ $change->hosting['domain_name'] }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <th>Old</th>
                    <th>New</th>
                </tr>
                <tr>
                    <th class="new-th">Title</th>
                    <td>{{ $change->title_old }}</td>
                    <td>{{ $change->title_old }}</td>
                </tr>
                <tr>
                    <th class="new-th">CMS</th>
                    <td>{{ $change->cms_old }}</td>
                    <td>{{ $change->cms_new }}</td>
                </tr>
                <tr>
                    <th class="new-th">HTTP_CODE</th>
                    <td>{{ $change->http_code_old }}</td>
                    <td>{{ $change->http_code_new }}</td>
                </tr>
                <tr>
                    <th class="new-th">Server</th>
                    <td>{{ $change->server_old }}</td>
                    <td>{{ $change->server_new }}</td>
                </tr>
                <tr>
                    <th class="new-th">X-Powered-BY</th>
                    <td>{{ $change->x_powered_by_old }}</td>
                    <td>{{ $change->x_powered_by_new }}</td>
                </tr>
            </tbody>
        </table>
        @endforeach
    </div>
    
</div>
@stop

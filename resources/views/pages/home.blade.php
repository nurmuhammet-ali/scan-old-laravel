@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="/css/app.css">
<script>
    @if($makeTheSound)
        let audio = new Audio('/success.mp3');
        audio.play();
    @endif
    window.theTimeOUT = setTimeout(function() {
        window.location.reload(true);
    }, 4000);
</script>
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
@endsection

@section('content')
<h1 class="info"><span class="common working"></span></h1>
<h1 class="info"><span class="common not-working"></span></h1>
<h1 class="info"><span class="common"></span></h1>
@if(count($results) > 0)
    <table class="container" id="table">
        <thead>
            <tr>
                <th><h1>Адрес сайта</h1><img class="site-sort sort" src="/img/sort-arrows.png" alt=""></th>
                <th><h1>IP</h1><img class="ip-sort sort" src="/img/sort-arrows.png" alt=""></th>
                <th><h1>Ошибка</h1><img class="error-sort sort" src="/img/sort-arrows.png" alt=""></th>
                <th><h1>Движок сайта</h1><img class="engine-sort sort" src="/img/sort-arrows.png" alt=""></th>
                <th>
                    <h1>Время ответа</h1><img class="time-sort sort" src="/img/sort-arrows.png" alt="">
                </th>
                <th>
                    <h1>http_code</h1><img class="code-sort sort" src="/img/sort-arrows.png" alt="">
                </th>
                <th @click="delayTimeOUT">
                    <h1>Последний чек</h1><img class="date-sort sort" src="/img/sort-arrows.png" alt="">
                </th>
                <th><h1>Подробно</h1></th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                @if($result->hosting != null)
                <tr class="tr-{{ ($result->http_code >= '400' || $result->http_code == 0) ? 'not-' : ''}}working">
                    <td class="{{ ($result->http_code >= '400' || $result->http_code == 0) ? 'not-' : ''}}working">
                        <a href="http://{{ $result->hosting->domain_name }}" target="_blank">{{ $result->hosting->domain_name }}</a>
                    </td>
                    <td>{{ $result->primary_ip }}</td>
                    <td class="long-td">
                        {{ $result->error ?: ''  }}
                    </td>
                    <td>{{ $result->cms /* ?? 'Не определён' */ }}</td>
                    <td>{{ $result->total_time }}</td>
                    <td>{{ $result->http_code }}</td>
                    <td>{{ $result->updated_at->format('H:i:s, d.m.y') }}</td>
                    <td>
                        <a href="{{ route('hostings_checked.show', ['hosting' => $result->hosting_id]) }}"> Test
                        </a>
                        @if(auth()->check())
                            <br>
                            <a href="{{ route('hostings.show', ['hosting' => $result->hosting_id]) }}">
                                Hosting 
                            </a>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

@else
    <h1>Hiç hili test ýok</h1>
@endif
@stop

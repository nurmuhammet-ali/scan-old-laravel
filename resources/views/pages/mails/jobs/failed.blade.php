@component('mail::message')
# Error, job failed

{{ $event->job }} job failed with exception {{ $event->exception }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
title : {{$dataDTO->getTitle() ? $dataDTO->getTitle() : "Answer"}}

{{$dataDTO->getDecription()}}

@component('mail::button', ['url' => ''])
OnlineSupport
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

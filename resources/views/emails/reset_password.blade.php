@component('mail::message')
# Dear User,

Click on the link to reset your password.

@component('mail::button', ['url' => $data['link']])
{{$data['link']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# This is your Employee Credential

Don't ever give this credential to other person.

@component('mail::table')
    |               |                        |
    | ------------- |:----------------------:|
    | Shop Name     | {{ $shop->name }}      |
    | Email         | {{ $employee->email }} |
    | Password      | {{ $password }}        |
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Visit Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# New Quote Request

You have received a new quote request:

- **Name:** {{ $quote->name }}
- **Email:** {{ $quote->email }}
- **Console Type:** {{ $quote->console_type }}
- **Issue:**
{{ $quote->issue }}

@component('mail::button', ['url' => route('services')])
View Services
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
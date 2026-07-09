<x-mail::message>
# Your Turn is Coming Up

Dear {{ $registration->donor->full_name }},

This is to notify you that your turn at the blood donation event is coming up.

**Queue Number:** {{ $registration->queue_number }}
**Event:** {{ $registration->event->name }}
**Venue:** {{ $registration->event->venue }}
**Date:** {{ $registration->event->event_date->format('F d, Y') }}

Please proceed to the donation area. Look for the staff at the registration desk.

Thank you for your participation!

Thanks,<br>
{{ config('app.name') }}
</x-mail::component>

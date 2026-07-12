<x-mail::message>
# Blood Donation Form Submission

Dear {{ $donor->full_name }},

Thank you for registering for the blood donation drive. Your form has been submitted successfully.

**Assigned Hospital:** {{ $donor->assignedHospital?->name }}

@if ($donor->assignedHospital?->code !== 'StLukes')
Please find attached your pre-filled blood donation form. Print it out and bring it with you on the event day. The medical section will be filled manually at the venue.
@else
Please proceed directly to the event venue on the day. Your hospital will handle the necessary paperwork on-site.
@endif

If you have any questions, please contact the event organizers.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
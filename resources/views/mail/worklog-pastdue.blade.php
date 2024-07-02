<x-mail::message>
# Log kerja anda melebihi jangka tempoh
## Tajuk
> {{ $worklog->workScopeTitle }}
{{--
## Penerangan
> {{ $worklog->description }}
## Tarikh Mula
> {{ $worklog->started_at }}
## Unit
> {{ $worklog->unit->name }}
## Bahagian
> {{ $worklog->unit->section->name }}

## Jangka tarikh penghantaran:
<x-mail::panel>
{{ $worklog->expected_at }}
</x-mail::panel> --}}

<x-mail::button :url="$url">
Buka log kerja
</x-mail::button>

Sila lakukan penghantaran kerja anda secepat mungkin.

Terima kasih,<br>
Sistem Log Kerja PMINT
</x-mail::message>

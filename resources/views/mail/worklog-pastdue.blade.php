<x-mail::message>
# Log kerja melebihi jangka tempoh

<x-mail::table>
|        | Table         | Example  |
| ------------- |:-------------:| --------:|
| ID      | Centered      | $10      |
| Title      | Right-Aligned | $20      |
</x-mail::table>

<x-mail::button :url="''">
Hantar log kerja
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>

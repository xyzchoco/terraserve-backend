@php
    $record = $getRecord();
@endphp

<div>
    <label class="text-sm font-semibold text-gray-700">Foto Lahan</label>
    @if ($record?->photo_land)
        <img src="{{ asset('storage/verifications/' . $record->photo_land) }}"
             class="w-40 rounded shadow border mt-2">
    @else
        <p class="text-gray-500">Tidak ada foto lahan.</p>
    @endif
</div>

@php
    $record = $getRecord();
@endphp

<div>
    <label class="text-sm font-semibold text-gray-700">Foto KTP</label>
    @if ($record?->photo_ktp)
        <img src="{{ asset('storage/verifications/' . $record->photo_ktp) }}"
             class="w-40 rounded shadow border mt-2">
    @else
        <p class="text-gray-500">Tidak ada foto KTP.</p>
    @endif
</div>

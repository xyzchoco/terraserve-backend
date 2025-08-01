@php
    $record = $getRecord();
@endphp

<div>
    <label class="text-sm font-semibold text-gray-700">Foto Wajah</label>
    @if ($record?->photo_face)
        <img src="{{ asset('storage/verifications/' . $record->photo_face) }}"
             class="w-40 rounded shadow border mt-2">
    @else
        <p class="text-gray-500">Tidak ada foto wajah.</p>
    @endif
</div>

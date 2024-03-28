@props([
    'label', 
    'name',
    'idSelector' => '',
    'isDisabled' => false,
    'noDefault' => false,
    'isSearch' => false,
    'options' => [],
    'keySelected' => '',
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<select
    {{ $attributes->merge([
        'name' => $name,
        'data-label' => $label,
        'class' => 'form-control',
        'id' => $idSelector,
        'disabled' => $isDisabled,
    ]) }}
>
    @if(!$noDefault)
        <option value="">{{ $isSearch ? '-' : '--' }}</option>
    @endif
    @foreach($options as $key => $value)
        <option value="{{ $key }}" {{ $key == $keySelected ? 'selected' : '' }}>{{ $value }}</option>
    @endforeach
</select>
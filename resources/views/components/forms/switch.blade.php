@props([
    'label' => '', 
    'type' => 'checkbox',
    'name' => '',
    'checked' => false,
    'isDisabled' => false,
    'hiddenInputValue' => '',
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<label class="switch">
    <input 
        {{ $attributes->merge([
            'type' => $type,
            'name' => $name,
            'data-label' => $label,
            'disabled' => $isDisabled,
        ]) }}
        {{ $checked ? 'checked' : '' }}
    />
    <span class="slider round"></span>
    @if ($hiddenInputValue != '')
        <input
            type="hidden"
            name={{ $name }}
            value={{ $hiddenInputValue }}
        />
    @endif
</label>

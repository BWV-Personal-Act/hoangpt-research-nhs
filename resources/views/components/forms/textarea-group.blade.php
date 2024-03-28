@props([
    'label', 
    'labelSide' => '',
    'type' => 'text',
    'name',
    'value' => null,
    'idSelector' => null,
    'isRequired' => false,
    'isDisabled' => false,
    'rows' => null,
    'cols' => null,
    'isHidden' => false,
    'valueHidden' => null,
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<div class="form-group">
    @if (isset($label))
        <x-forms.label :label="$label" :labelSide="$labelSide" :isRequired="$isRequired" class="{{ $attributes['classLabel'] }}" />
    @endif

    <textarea 
        {{ $attributes->merge([
            'rows' => $rows,
            'cols' => $cols,
            'class' => 'form-control',
            'name' => $name,
            'id' => $idSelector,
            'data-label' => $label,
            'disabled' => $isDisabled,
        ]) }}
    >{{ $value }}</textarea>
    @if ($isHidden)
        <input
            type="hidden"
            name="{{ $name }}"
            value={{ !empty($valueHidden) ? $valueHidden : $value }}
        />
    @endif
    {{ $slot }}
</div>
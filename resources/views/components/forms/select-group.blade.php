@props([
    'label',
    'name',
    'idSelector' => '',
    'isRequired' => false,
    'isDisabled' => false,
    'noDefault' => false,
    'isSearch' => false,
    'options' => [],
    'keySelected' => '',
    'isHidden' => false,
    'isChosen' => true,
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<div class="form-group">
    @if (isset($label))
        <x-forms.label :label="$label" :isRequired="$isRequired" class="{{ $attributes['classLabel'] }}" />
    @endif
    <div class="{{ $attributes['classDiv'] }}">
        <x-forms.select
            :label="$label"
            :name="$name"
            :idSelector="$idSelector"
            :options="$options"
            :keySelected="$keySelected"
            :isDisabled="$isDisabled"
            :isSearch="$isSearch"
            :noDefault="$noDefault"
            class="{{ $attributes['classSelect'] }}"
            class="{{ $isChosen ? 'chosen-select' : '' }}"
        />
        @if ($isHidden)
            <input
                type="hidden"
                name="{{ $name }}"
                value={{ $keySelected }}
            />
        @endif
    </div>
</div>

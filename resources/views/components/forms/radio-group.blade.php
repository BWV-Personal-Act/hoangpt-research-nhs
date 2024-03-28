@props([
    'label', 
    'type' => 'radio',
    'name',
    'idSelector' => '',
    'isRequired' => false,
    'isDisabled' => false,
    'dataDefault' => false,
    'options' => [],
    'keySelected' => '',
    'isHidden' => false,
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
    <div class="check" data-default="{{ $dataDefault }}">
        @foreach ($options as $key => $value)
            <label>
                <input
                    {{ $attributes->merge([
                        'type' => $type,
                        'name' => $name,
                        'value' => $key,
                        'id' => $idSelector . '-' . $key,
                        'class' => 'minimal-blue i-radio form-check-input',
                        'checked' => $key == $keySelected,
                        'disabled' => $isDisabled,
                    ]) }}
                />
                <span>{{ $value }}</span>
            </label>
        @endforeach
    </div>
    @if ($isHidden)
        <input
            type="hidden"
            name="{{ $name }}"
            value="{{ $keySelected }}"
        />
    @endif
</div>
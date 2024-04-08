@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'id' => '',
    'placeholder' => '',
    'isDisabled' => false,
    'isReadonly' => false,
    'isRequired' => false,
    'isHidden' => false,
    'dataDefault' => null,
    'labelFurtureDate' => ''
])

<div class="form-group {{ $attributes['class'] }}">
    @if (isset($label))
        <x-forms.label :label="$label" name="{{ $label }}" isRequired="{{ $isRequired }}" class="{{ $attributes['classLabel'] }}" />
    @endif

    <x-forms.date
        label="{{ $label }}"
        labelFurtureDate="{{ $labelFurtureDate }}"
        name="{{ $name }}"
        value="{{ $value }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        isDisabled="{{ $isDisabled }}"
        isReadonly="{{ $isReadonly }}"
        isRequired="{{ $isRequired }}"
        isHidden="{{ $isHidden }}"
        dataDefault="{{ $dataDefault }}"
        classInput="{{ $attributes['classInput'] }}"
    />

    @if ($isHidden)
        <input
            type="hidden"
            name="{{ $name }}"
            value="{{ $value }}"
        />
    @endif
</div>

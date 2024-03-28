@php
    $componentName = 'forms.text';
    $props = [
        'label', 
        'labelSide' => '',
        'type' => 'text',
        'name',
        'value' => '',
        'idSelector' => '',
        'placeholder' => '',
        'isDisabled' => false,
        'isReadonly' => false,
        'isRequired' => false,
    ];
    $allProps = array_merge($props, [
        'isHidden' => false,
        'valueHidden' => '',
    ]);
@endphp
@props($allProps)

<div class="form-group">
    @if (isset($label))
        <x-forms.label 
            :label="$label" 
            :labelSide="$labelSide" 
            :isRequired="$isRequired" 
            class="{{ $attributes['classLabel'] }}" />
    @endif
    <x-forms.text 
        :type="$type"
        :label="$label"
        :name="$name"
        :value="$value"
        :idSelector="$idSelector"
        :placeholder="$placeholder"
        :isDisabled="$isDisabled"
        :isHidden="$isHidden"
        :isReadonly="$isReadonly"
        class="{{ $attributes['classInput'] }}"
    />
    @if ($isHidden)
        <input
            type="hidden"
            name="{{ $name }}"
            value={{ !empty($valueHidden) ? $valueHidden : $value }}
        />
    @endif
</div>


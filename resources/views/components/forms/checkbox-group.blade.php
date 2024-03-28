@props([
    'label' => null, 
    'hasDivFormCheck' => false, 
    'type' => 'checkbox',
    'name' => '',
    'isRequired' => false,
    'isDisabled' => false,
    'noDefault' => false,
    'options' => [],
    'valueChecked' => [],
    'ratioBreak' => null,
])

<div class="form-group">
    @if (isset($label))
        <x-forms.label :hasDivFormCheck="$hasDivFormCheck" :label="$label" :isRequired="$isRequired" class="{{ $attributes['classLabel'] }}" />
    @endif
    <div class="check">
        @foreach($options as $key => $value)
            <label class="{{ !empty($ratioBreak) ? 'mr-5' : '' }}">
                <input 
                    {{ $attributes->merge([
                        'type' => $type,
                        'name' => $name.'[]',
                        'data-label' => $label,
                        'class' => 'minimal-blue i-checkbox form-check-input',
                        'disabled' => $isDisabled,
                        'value' => $key,
                        'checked' => in_array($key, $valueChecked),
                    ]) }}
                />
                <span>{{ $value }}</span>
            </label>
            @if (!empty($ratioBreak) && ($key + 1) % $ratioBreak == 0)
                <br />
            @endif
        @endforeach
    </div>
</div>
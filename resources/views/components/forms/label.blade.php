@props([
    'label' => null, 
    'labelSide' => '',
    'isRequired' => false, 
    'hasDivFormCheck' => false,
])

@if ($hasDivFormCheck)
    <div class="form-check">
@endif
    <label class="{{ $attributes['class'] }}">
        {{ $label }}
        @if ($isRequired)
            <span class="red">*</span>
        @endif
        @if (!empty($labelSide))
            <span class="title-side">{{ $labelSide }}</span>
        @endif
        {{ $slot }}
    </label>
@if ($hasDivFormCheck)
    </div>
@endif


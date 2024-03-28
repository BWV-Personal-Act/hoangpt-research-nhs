@props([
    'type' => 'submit',
    'label',
    'isDisabled' => false
])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn btn--shadow btn-round btn-simple', 'disabled' => $isDisabled]) }}>
    {{ $label }}
</button>

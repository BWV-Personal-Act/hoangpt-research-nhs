@props([
    'label' => '', 
    'labelFurtureDate' => '', 
    'name' => '',
    'value' => '',
    'id' => '',
    'placeholder' => '',
    'isDisabled' => false,
    'isReadonly' => false,
    'isRequired' => false,
    'isHidden' => false,
    'dataDefault' => null,
])

<div class="position-relative">
    <input 
        type="text"
        placeholder="yyyy/mm/dd"
        name="{{ $name }}"
        value="{{ $value }}"
        data-label="{{ $label }}"
        data-label-furture-date="{{ $labelFurtureDate }}"
        class="form-control datepicker {{ $attributes['classInput'] }}"
        id="{{ $id }}"
        {{ $isDisabled ? 'disabled' : '' }}
        data-default={{ $dataDefault }}
        {{ !empty($dataDefault) ? 'data-is-default=true' : 'data-is-default=false' }}
        autocomplete="off"
    >
    <span class="calendar-btn">
        <i class="fa-regular fa-calendar" style="position: absolute;top: 11px;right: 11px;"></i>
    </span>
</div>
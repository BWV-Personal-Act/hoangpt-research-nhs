@props([
    'label' => '', 
    'name' => '',
    'idSelector' => '',
    'isDisabled' => false,
    'isRequired' => false,
    'accept' => '',
    // Set a file name to make it look like the file input is already selected & use it for front-end validation
    'initFileName' => '',  
    // to create error message
    'acceptLabel' => '', 
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<div class="form-group m-0">
    @if (isset($label))
        <x-forms.label :label="$label" :isRequired="$isRequired" class="{{ $attributes['classLabel'] }}" />
    @endif
</div>
<x-forms.file-single 
    :label="$label"
    :name="$name"
    :idSelector="$idSelector"
    :isDisabled="$isDisabled"
    :accept="$accept"
    :initFileName="$initFileName"
    :class="$attributes['classInput']"
    :acceptLabel="$acceptLabel"
/>


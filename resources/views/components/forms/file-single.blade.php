@props([
    'label' => '',
    'name' => '',
    'idSelector' => '',
    'isDisabled' => false,
    'isHidden' => false,
    'accept' => '',
    // Set a file name to make it look like the file input is already selected & use it for front-end validation
    'initFileName' => '',
    // to create error message
    'acceptLabel' => '',
])

@php
    // set default id
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }

    // get filename & extension of initFileName
    if (!empty($initFileName)) {
        extract(pathInfo($initFileName));
    }
@endphp

<div class="file-single-wrapper">
    <input
    {{ $attributes->merge([
        'type' => 'file',
        'name' => $name,
        'data-label' => $label,
        'class' => 'form-control file-single',
        'id' => $idSelector,
        'disabled' => $isDisabled,
        'accept' => $accept,
        'data-accept-label' => $acceptLabel,
    ]) }}

    {!! !empty($initFileName) ? "init-file-name=\"true\"" : '' !!}

    {{ $isHidden ? 'hidden' : '' }}
    />

    @if(!empty($initFileName))
        <span class="init-file-name form-control">
            <span class="filename"> {{ $filename }} </span>
            <span class="extenstion"> {{ !empty($extension) ? '.' . $extension : '' }} </span>
        </span>
    @endif
</div>

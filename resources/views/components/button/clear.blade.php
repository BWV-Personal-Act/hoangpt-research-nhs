@props([
    'label' => 'クリア',
    'screen' => '',
    'id' =>'btn-clear'
])

<button
	type="button" class="btn btn--shadow btn-round btn-simple btn-clear-search"
	data-url="{{ route('common.resetSearch') }}"
    data-screen="{{ $screen }}"
    id="{{ $id }}"
>
    {{ $label }}
</button>

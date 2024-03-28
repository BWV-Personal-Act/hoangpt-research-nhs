<x-button.base 
    type="button" 
    :isDisabled="$isDisabled" 
    :label="$label" 
    data-toggle="modal" 
    :data-target="'#' . $id" />

@push('modals')
    <x-modals.modal 
        :id="$id"
        :modalClass="$modalClass"
        :actions="$actions"  
        :actionsLabel="$actionsLabel"
        :actionsDissmiss="$actionsDissmiss"  
        :actionsType="$actionsType"      
        :formAttrs="$formAttrs"    
        :hasCustomActions="$hasCustomActions"
        :useForm="$useForm"
    >
        {{ $slot }}
    </x-modals.modal>
@endpush
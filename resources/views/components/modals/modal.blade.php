@php
    $modalBody = $useForm ? 'form' : 'div';
@endphp

<div class="modal modal-component fade" id="{{ $id }}">
    <div class="modal-dialog row justify-content-center">
        <div class="modal-content {{ $modalClass }}">
            <{{ $modalBody }} 
                @class(['modal-body', 'modal-form' => $useForm]) 
                {!! arrToAttr($formAttrs) !!}
            >
                <div class="row">
                    <div class="col-12">
                        {{-- Slot for modal's content --}}
                        {{ $slot }}     
                    </div>

                    @unless ($hasCustomActions)
                        <div class="col-12">
                            <div class="text-right col-12">
                                @foreach ($actions as $name)
                                    <x-button.base 
                                        :type="isset($actionsType[$name]) ? $actionsType[$name] : 'button'"
                                        :class="$name"
                                        :label="isset($actionsLabel[$name]) ? $actionsLabel[$name] : $name" 
                                        :data-action="$name"
                                        :data-dismiss="in_array($name,$actionsDissmiss) ? 'modal' : ''"/>
                                @endforeach
                            </div>
                        </div>
                    @endunless
                </div>
            </{{ $modalBody }}>
        </div>
    </div>
</div>
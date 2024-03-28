<?php

namespace App\View\Components\Modals;

use Closure;

class ModalGroup extends Modal
{
    public string $label;

    public bool $isDisabled;

    /**
     * Create a new component instance.
     *
     * @param mixed $id
     * @param mixed $modalClass
     * @param mixed|null $actions
     * @param mixed|null $actionsLabel
     * @param mixed|null $actionsType
     * @param mixed|null $actionsDissmiss
     * @param mixed $hasCustomActions
     * @param mixed $useForm
     * @param mixed $formAttrs
     * @param mixed $label
     * @param mixed $isDisabled
     * @return void
     */
    public function __construct(
        $id,
        $modalClass = '',
        $actions = null,
        $actionsLabel = null,
        $actionsType = null,
        $actionsDissmiss = null,
        $hasCustomActions = false,
        $useForm = true,
        $formAttrs = [],
        $label = '',
        $isDisabled = false,
    ) {
        $this->label = $label;
        $this->isDisabled = $isDisabled;
        parent::__construct(
            $id,
            $modalClass,
            $actions,
            $actionsLabel,
            $actionsType,
            $actionsDissmiss,
            $hasCustomActions,
            $useForm,
            $formAttrs,
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render() {
        return view('components.modals.modal-group');
    }
}

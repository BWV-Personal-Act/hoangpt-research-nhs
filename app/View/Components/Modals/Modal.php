<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\View\Component;

class Modal extends Component
{
    public string $id;

    public string $modalClass;

    /* actions are modal footer buttons */
    public array $actions;

    public array $actionsLabel;

    public array $actionsType;

    /* which actions will dissmiss modal when clicked */
    public array $actionsDissmiss;

    /* when TRUE, the component will not set any actions ( the slot should includes your custom actions ) */
    public bool $hasCustomActions;

    public bool $useForm;

    /* modal form attributes */
    public array $formAttrs;

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
    ) {
        $this->id = $id;
        $this->modalClass = $modalClass;
        $this->actions = $actions ?? ['cancel', 'submit'];
        $this->actionsLabel = $actionsLabel ?? [
            'submit' => 'Submit',
            'cancel' => 'Cancel',
            'delete' => 'Delete',
            'no' => 'No',
            // declare more action here
        ];
        $this->actionsType = $actionsType ?? [
            'submit' => 'submit',
        ];
        $this->actionsDissmiss = $actionsDissmiss ?? ['cancel', 'submit', 'no'];
        $this->hasCustomActions = $hasCustomActions;
        $this->useForm = $useForm;
        $this->formAttrs = $formAttrs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render() {
        return view('components.modals.modal');
    }
}

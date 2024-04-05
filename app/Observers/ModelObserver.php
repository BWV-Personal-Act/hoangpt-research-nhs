<?php

namespace App\Observers;

use App\Libs\{ValueUtil};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Log, Route};

class ModelObserver
{
    public function creating(Model $model) {
    }

    public function updating(Model $model) {
    }

    public function saving(Model $model) {
        app()->runningInConsole() ? '' : Log::info($model->toArray());
    }
}

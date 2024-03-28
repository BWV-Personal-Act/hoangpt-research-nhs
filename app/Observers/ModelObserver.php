<?php

namespace App\Observers;

use App\Libs\{ValueUtil};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Log, Route};

class ModelObserver
{
    public function creating(Model $model) {
        // $model->created_at = Carbon::now();
        // $model->updated_at = Carbon::now();
        // $model->created_by = app()->runningInConsole() ? 0 : auth()->id();
        // $model->updated_by = app()->runningInConsole() ? 0 : auth()->id();
        // $model->deleted_by = null;
        // $model->deleted_at = null;
    }

    public function updating(Model $model) {
        // if ($model->del_flg == ValueUtil::constToValue('common.del_flg.INVALID')) { // del_flg == 1
        //     $model->deleted_at = Carbon::now();
        //     $model->deleted_by = app()->runningInConsole() ? 0 : auth()->id();
        //     $model->updated_at = Carbon::now();
        //     $model->updated_by = app()->runningInConsole() ? 0 : auth()->id();
        // } elseif ($model->del_flg == ValueUtil::constToValue('common.del_flg.VALID')) { // del_flg == 0
        //     $model->updated_by = app()->runningInConsole() ? 0 : auth()->id();
        //     $model->updated_at = Carbon::now();
        //     $model->deleted_at = null;
        //     $model->deleted_by = null;
        // } else {
        //     $model->updated_at = Carbon::now();
        //     $model->updated_by = app()->runningInConsole() ? 0 : auth()->id();
        // }
    }

    public function saving(Model $model) {
        app()->runningInConsole() ? '' : Log::info($model->toArray());
    }
}

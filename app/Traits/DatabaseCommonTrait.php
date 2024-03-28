<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait DatabaseCommonTrait
{
    public function commonColumns(Blueprint $table) {
        $table->datetime('created_at');
        $table->datetime('updated_at')->nullable();
        $table->datetime('deleted_at')->nullable();
    }

    public function commonCharset(Blueprint $table) {
        $table->charset = 'utf8';
        $table->collation = 'utf8_general_ci';
    }
}

<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait DatabaseCommonTrait
{
    public function commonColumns(Blueprint $table) {
        $table->tinyInteger('del_flg')->default(0)->nullable();
        $table->datetime('created_at')->nullable();
        $table->string('created_by', 12)->nullable();
        $table->datetime('updated_at')->nullable();
        $table->string('updated_by', 12)->nullable();
        $table->datetime('deleted_at')->nullable();
        $table->string('deleted_by', 12)->nullable();
    }

    public function commonCharset(Blueprint $table) {
        $table->charset = 'utf8';
        $table->collation = 'utf8_general_ci';
    }
}

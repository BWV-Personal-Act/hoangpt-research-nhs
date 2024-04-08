<?php

use App\Traits\DatabaseCommonTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    use DatabaseCommonTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();

            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('name', 100);
            $table->unsignedBigInteger('group_id');
            $table->date('started_date');
            $table->tinyInteger('position_id');

            $this->commonColumns($table);
            $this->commonCharset($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user');
    }
};

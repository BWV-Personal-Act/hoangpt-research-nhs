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
        Schema::create('group', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();

            $table->string('name', 255);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('group_leader_id');
            $table->integer('group_floor_number');

            $table->foreign('group_leader_id')->references('id')->on('user')->onDelete('cascade');

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
        Schema::dropIfExists('group');
    }
};

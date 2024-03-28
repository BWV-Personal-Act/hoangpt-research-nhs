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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->tinyInteger('mode')->nullable()->default(0);
            $table->string('body', 255)->nullable();

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
        Schema::dropIfExists('maintenance');
    }
};

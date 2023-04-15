<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loggio', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('activity_slug');
            $table->integer('count')->default(0);

            $table->index(['date']);
            $table->unique(['date', 'activity_slug']);


        });
    }


    public function down()
    {
        Schema::dropIfExists('loggio');
    }
};

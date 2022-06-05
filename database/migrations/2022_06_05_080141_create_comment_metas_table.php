<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_metas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('comment_id')->unsigned()->nullable();
            $table->string('meta_key', 100);
            $table->text('meta_value');
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы users
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_metas');
    }
};

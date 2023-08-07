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
        Schema::create('post_user', function (Blueprint $table) {
            //user_idとpost_idを外部キーに設定
            $table->foreignID('post_id')->constrained();//post_idはpostsテーブルのidを参照
            $table->foreignID('user_id')->constrained();//user_idはusersテーブルのidを参照
            $table->primary(['post_id', 'user_id']);
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_user');
    }
};

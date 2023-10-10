<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignID('category_id')->constrained()->nullable();//category_idはcategoriesテーブルのidを参照
        });

    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};

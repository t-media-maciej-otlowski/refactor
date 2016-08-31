<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsAttributes extends Migration {

    use SoftDeletes;

    public function up() {
        Schema::create('documents_attributes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('documents__id');
            $table->string('name');
            $table->text('value');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::drop('documents_attributes');
    }

}

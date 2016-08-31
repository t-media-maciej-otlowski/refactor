<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsFiles extends Migration {

    use SoftDeletes;

    public function up() {
        Schema::create('documents_files', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('documents__id');
            $table->string('name');
            $table->string('fullname');
            $table->string('extension');
            $table->string('hash');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::drop('documents_files');
    }

}

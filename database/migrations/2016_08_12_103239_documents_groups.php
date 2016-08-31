<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsGroups extends Migration {

    use SoftDeletes;

    public function up() {
        Schema::create('documents_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parent')->nullable();
            $table->string('name');
            $table->string('description');
            $table->string('number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::drop('documents_groups');
    }

}

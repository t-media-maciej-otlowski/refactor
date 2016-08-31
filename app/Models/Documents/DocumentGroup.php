<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentGroup extends \Illuminate\Database\Eloquent\Model {

    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'documents_groups';
    protected $date = ['deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'id_parent',
        'name',
        'description',
        'number'
    ];

    /*  public function documents() {
      return $this->hasMany('Document', 'id', 'documents_groups__id');
      }

     */
}

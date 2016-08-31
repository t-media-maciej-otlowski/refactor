<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Documents\Document;


class DocumentFile extends \Illuminate\Database\Eloquent\Model {

    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'documents_files';
    protected $date = ['deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'documents__id',
        'name',
        'fullname',
        'extension',
        'hash'
    ];

    public function document() {
        return $this->belongsTo('App\Models\Documents\Document', 'id', 'documents__id');
    }

    /*
      public function createAttribute($document) {
      $param = [
      'documentId' => $document->id,
      'name' => $document->type . str_random(3),
      'description' => str_random(10),
      'confirmed' => (bool) rand(0, 1)
      ];
      $attribute = self::create($param);
      return $attribute;
      }
     * 
     */
}

<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Documents\Document;
use App\Models\Documents\DocumentGroup;
use App\Models\Documents\DocumentFile;

class DocumentAttributes extends \Illuminate\Database\Eloquent\Model {

    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'documents_attributes';
    protected $date = ['deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'documents__id',
        'name',
        'value',
        'type'
    ];

    public function document() {
        return $this->belongsTo('App\Models\Documents\Document', 'documents__id', 'id');
    }
     
}

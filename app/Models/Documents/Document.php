<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Documents\DocumentAttributes;
use App\Models\Documents\DocumentGroup;
use App\Models\Documents\DocumentFile;

class Document extends \Illuminate\Database\Eloquent\Model {

    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'documents';
    protected $date = ['deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'name',
        'documents_groups__id',
        'description',
        'type',
        'order_number',
        'user__id'
    ];

    public function attributes() {
        return $this->hasMany('App\Models\Documents\DocumentAttributes', 'documents__id', 'id');
    }

    public function group() {
        return $this->belongsTo('App\Models\Documents\DocumentGroup', 'documents_groups__id', 'id');
    }

    public function file() {
        return $this->belongsTo('App\Models\Documents\DocumentFile', 'id', 'documents__id');
    }
    
}

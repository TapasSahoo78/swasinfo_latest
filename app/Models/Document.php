<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'documents';

    protected $fillable=[
        'uuid',
        'title',
        'documentable_type',
        'documentable_id',
        'document_type',
        'file',
        'status'

    ];



    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function documentable(){
        return $this->morphTo();
    }
}

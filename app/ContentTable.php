<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentTable extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_tables";
    public $timestamps = true;
    protected $fillable = [
        'content_id',
        'is_primary_key',
        'column_name',
        'type',
        'nullable',
        'size'
    ];
}

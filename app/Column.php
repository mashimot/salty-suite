<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    //
    protected $table = "columns";
    public $timestamps = true;
    protected $fillable = [
        'row_id',
        'position'
    ];

    public function contents(){
        return $this->hasMany('App\Content', 'column_id', 'id')->orderBy('position', 'ASC');
    }

    public function row(){
        return $this->belongsTo('App\Row', 'row_id', 'id');
    }
}

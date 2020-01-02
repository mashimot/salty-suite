<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    //
    protected $table = 'rows';
    public $timestamps = true;
    protected $fillable = [
        'grid',
        'page_id',
        'position'
    ];

    public function columns(){
        return $this->hasMany('App\Column', 'row_id', 'id')->orderBy('position', 'ASC');
    }

    public function page(){
        return $this->belongsTo('App\Page', 'page_id', 'id');
    }
}

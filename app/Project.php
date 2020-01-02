<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "projects";
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];
}

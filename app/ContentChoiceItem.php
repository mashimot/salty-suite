<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentChoiceItem extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_choices_items";
    public $timestamps = true;
    protected $fillable = [
        'content_choice_id',
        'text',
        'value',
        'position'
    ];
}

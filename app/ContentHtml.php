<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentHtml extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_htmls";
    public $timestamps = true;
    protected $fillable = [
        'content_id',
        'content_choice_id', //nullable
        'content_html_tag_id',
        'label',
        'text',
        'data',
        'src'
    ];

    public function content(){
        return $this->belongsTo('App\Content', 'content_id', 'id');
    }

    public function content_html_tag(){
        return $this->belongsTo('App\ContentHtmlTag', 'content_html_tag_id', 'id');
    }

    public function content_choice(){
        return $this->hasOne('App\ContentChoice', 'id', 'content_choice_id');
    }
}

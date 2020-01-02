<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentHtmlTag extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_htmls_tags";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
        'content_html_category_id'
    ];

    public function html_category(){
        return $this->belongsTo('App\ContentHtmlCategory', 'content_html_category_id', 'id');
    }

    public function contents_htmls(){
        return $this->hasMany('App\ContentHtml', 'content_html_tag_id', 'id');
    }
    
}

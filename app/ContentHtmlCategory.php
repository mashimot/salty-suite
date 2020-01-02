<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentHtmlCategory extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_htmls_categories";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description'
    ];

    public function contents_htmls_tags(){
        return $this->hasMany('App\ContentHtmlTag', 'content_html_category_id', 'id');
    }
}

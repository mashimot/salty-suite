<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents";
    public $timestamps = true;
    protected $fillable = [
        'column_id',
        'position'
    ];

    public function getContent($id){
        $content    = $this->with('content_html')->find($id);
        $h          = $content->content_html;
        $data       = [
            'html' => [
                'tag' => !is_null($h->content_html_tag)? $h->content_html_tag->name : '',
                'content_choice_id' => $h->content_choice_id,
                'category' => $h->content_html_tag->html_category->name,
                'choices' => !is_null($h->content_choice)? $h->content_choice->choices_items : [],
                'fields' => [],
                'label' => $h->label,
                'src' => $h->src,
                'text'=> $h->text,
                'data'=> $h->data
            ]
        ];

        if($h->content_html_tag->html_category->id == 1){
            if(!is_null($content->content_table)){
                $data['table'] = [
                    'column_name'=> $content->content_table->column_name,
                    'type'=> $content->content_table->type,
                    'size'=> $content->content_table->size,
                    'nullable' => (boolean)$content->content_table->nullable
                ];
            }
        }
        return $data;
    }

    public function content_html(){
        return $this->hasOne('App\ContentHtml', 'content_id', 'id');
    }

    public function content_table(){
        return $this->hasOne('App\ContentTable', 'content_id', 'id');
    }

    public function column(){
        return $this->belongsTo('App\Column', 'column_id', 'id');
    }
}

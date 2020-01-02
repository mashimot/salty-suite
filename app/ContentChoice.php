<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentChoice extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = "contents_choices";
    public $timestamps = true;
    protected $fillable = [
        'description'
    ];

    public function choices_items(){
        return $this->hasMany('App\ContentChoiceItem', 'content_choice_id', 'id')->orderBy('position');
    }

    public function content_html(){
        return $this->hasOne('App\ContentHtml', 'content_choice_id', 'id');
    }    

    public function scopeConvertChoices($query, $dataPerPage = 2){
        $choices = $query->with([
            'choices_items' => function($query){
                $query->select('id', 'content_choice_id', 'text', 'value', 'position');
            }
        ])->paginate($dataPerPage);

        $choices->getCollection()->transform(function($choice){
            return [
                "description" => $choice->description,
                'html' => [
                    "content_choice_id" => $choice->id, 
                    "content_html_tag_id" => 2,
                    "category" => "form",
                    "tag" => 'radio',
                    "label" => 'Type your Text',
                    "choices" => $choice->choices_items->toArray()
                ]
            ];
        });
        
        return $choices;
    }
}

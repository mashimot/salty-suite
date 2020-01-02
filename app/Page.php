<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Page extends Model
{
    //
    private $projectId = 1;
    protected $primaryKey = 'id';
    protected $table = "pages";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'project_id',
        'position'
    ];

    public function rows(){
        return $this->hasMany('App\Row', 'page_id', 'id')->orderBy('position', 'ASC');
    }


    public function scopeByProject($query, $projectId){
        return $query->with('rows')
        ->where('project_id', $projectId);
    }

    public function scopeGetConverted($query){
        $newPages   = [];

        $pages      = $query->paginate($query->count());
        foreach($pages->items() as $pageIndex => $page){
            $newPages[] = [
                'id' => $page->id,
                'position' => $page->position,
                'rows' => []
            ];
            foreach($page->rows AS $rowIndex => $row){
                $newPages[$pageIndex]['rows'][] = [
                    'id' => $row->id,
                    'grid' =>  $row->grid,
                    'position' => $row->position,
                    'columns' => []
                ];
                foreach($row->columns AS $columnIndex => $column){
                    $newPages[$pageIndex]['rows'][$rowIndex]['columns'][] = [
                        'id' => $column->id,
                        'position' => $column->position,
                        'contents' => []
                    ];
                    foreach($column->contents AS $contentIndex => $content){
                        $r = Content::with('content_html')->find($content->id);
                        $choices = [];
                        if(isset($r->content_html->content_choice->choices_items)){
                            foreach($r->content_html->content_choice->choices_items as $i){
                                $choices[] = [
                                    'id' => $i->id,
                                    'text' => $i->text,
                                    'value' => $i->value
                                ];
                            }
                            //dd($choices);
                        }
                        $newHtml = [
                            'content_html_tag_id' => $r->content_html->content_html_tag_id,
                            'content_choice_id' => $r->content_html->content_choice_id,
                            'content_id' => $r->content_html->content_id,
                            'label' => $r->content_html->label,
                            'choices' => $choices,
                            'text' => $r->content_html->text,
                            'data' => $r->content_html->data,
                            'src' => $r->content_html->src,
                            'category' => $r->content_html->content_html_tag->html_category->name,
                            'tag' => $r->content_html->content_html_tag->name,
                        ];
                        
                        $newPages[$pageIndex]['rows'][$rowIndex]['columns'][$columnIndex]['contents'][] = [
                            'id' => $content->id,
                            'html' => $newHtml,
                            'definition' => !is_null($content->content_table)? $content->content_table : (object)[]
                        ];
                    }
                }
            }
        }
        
        $pagesToArray = $pages->toArray();
        $pagesToArray['data'] = $newPages;

        return $pagesToArray;
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContentHtml;
use App\ContentHtmlCategory;
use App\ContentChoice;
use Illuminate\Support\Str;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contentHtml = new ContentHtml;
        $result = $contentHtml->select([
            'html_tag.id as content_html_tag_id',
            'html_tag.name as tag',
            'html_category.id as category_id',
            'html_category.name as category',
            'contents_htmls.id as content_html_id',
            'contents_htmls.content_choice_id as content_choice_id',
            'contents_htmls.label as label',
            'contents_htmls.text as text',
            'contents_htmls.src as src',
            'cci.id as choice_id',
            'cci.text as choice_text',
            'cci.value as choice_value'
        ])
        ->join('contents_htmls_tags as html_tag', 'html_tag.id', '=', 'contents_htmls.content_html_tag_id')
        ->join('contents_htmls_categories as html_category', 'html_category.id', '=', 'html_tag.content_html_category_id')
        ->leftJoin('contents_choices as cc', function($join){
            $join->on('cc.id', '=', 'contents_htmls.content_choice_id');
        })
        ->leftJoin('contents_choices_items as cci', 'cci.content_choice_id', '=', 'cc.id')
        ->where(function($query) {
            $query->where('html_tag.id', "<>", 1)->where('html_tag.id', "<>", 2);
        })
        ->whereNull("contents_htmls.content_id")
        ->orderBy('html_tag.id')
        ->get();

        $data = [];
        foreach($result as $r){
            $tagId = $r->content_html_tag_id;

            $data[$r->category][] =  [
                'html' => [
                    "content_html_id" => $r->content_html_id,
                    "content_html_tag_id" => $tagId,
                    "category_id" => $r->category_id,
                    "tag" => !is_null($r->content_html_id)? $r->tag: 'form',
                    "category" => $r->category,
                    "label" => $r->label,
                    "text" => $r->text,
                    "src" => $r->src
                ]
            ];
        }
        
        return response()->json([
            'success' => true,
            'message' => 'any',
            'tools' => $data
        ]);               
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json([
            'isAuth' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

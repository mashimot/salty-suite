<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Page;
use App\Row;
use App\Column;
use App\Content;
use App\ContentHtml;
use App\ContentTable;

use App\ContentChoice;
use App\ContentChoiceItem;

use App\ContentHtmlCategory;
use App\ContentHtmlTag;

use DB;
use Illuminate\Http\Response;
use stdClass;

class PageController extends Controller
{
    private $projectId = 111773;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {

        //dd(1);
        //dd($v);

        /*$contentChoiceCreate = ContentChoice::create([
            'description' => 'Bass Players'
        ]);
        $contentChoiceItem = [
            [
                'content_choice_id' => $contentChoiceCreate->id,
                'text' => 'Les Claypool',
                'value' => 1,
                'position' => 1
            ],[
                'content_choice_id' => $contentChoiceCreate->id,
                'text' => 'Geddy Lee',
                'value' => 2,
                'position' => 2
            ]
        ];
        foreach($contentChoiceItem as $item){        
            ContentChoiceItem::create($item);
        }*/

        /*$contentChoiceCreate = ContentChoice::create([
            'description' => 'Escala Likert'
        ]);*/
   /*
        $contentChoiceItem = [
            [
                'content_choice_id' => 1,
                'text' => 'Discordo Totalmente',
                'value' => 1,
                'position' => 1
            ],[
                'content_choice_id' => 1,
                'text' => 'Discordo',
                'value' => 2,
                'position' => 2
            ],[
                'content_choice_id' => 1,
                'text' => 'Discordo Totalmente e Nem Discordo',
                'value' => 3,
                'position' => 3
            ],[
                'content_choice_id' => 1,
                'text' => 'Concordo',
                'value' => 4,
                'position' => 4
            ],[
                'content_choice_id' => 1,
                'text' => 'Concordo Totalmente',
                'value' => 5,
                'position' => 5
            ],[
                'content_choice_id' => 1,
                'text' => 'NA (Não Aplicável)',
                'value' => 0,
                'position' => 6
            ]
        ];
        foreach($contentChoiceItem as $item){        
            ContentChoiceItem::create($item);
        }*/
        
/*
        $contentHtmlCategory = [
            [
                'name' => 'form',
                'description' => 'form Input'
            ],[
                'name' => 'html',
                'description' => 'html'
            ],[
                'name' => 'headings',
                'description' => 'headings'
            ],[
                'name' => 'formatting',
                'description' => 'formatting'
            ]
        ];
        foreach($contentHtmlCategory as $cat){
            ContentHtmlCategory::create($cat);
        }*/
        /*
        $contentHtmlTag = [
            [
                'name' => 'number',
                'content_html_category_id' => 1
            ],[
                'name' => 'date',
                'content_html_category_id' => 1
            ],[
                'name' => 'text',
                'content_html_category_id' => 1
            ],[
                'name' => 'textarea',
                'content_html_category_id' => 1
            ],[
                'name' => 'file',
                'content_html_category_id' => 1
            ],[
                'name' => 'html',
                'content_html_category_id' => 2
            ],[
                'name' => 'image',
                'content_html_category_id' => 2
            ],[
                'name' => 'h1',
                'content_html_category_id' => 3
            ],[
                'name' => 'h2',
                'content_html_category_id' => 3
            ],[
                'name' => 'h3',
                'content_html_category_id' => 3
            ],[
                'name' => 'h4',
                'content_html_category_id' => 3
            ],[
                'name' => 'h5',
                'content_html_category_id' => 3
            ],[
                'name' => 'h6',
                'content_html_category_id' => 3
            ],[
                'name' => 'legend',
                'content_html_category_id' => 4
            ]
        ];
        foreach($contentHtmlTag as $tag){
            ContentHtmlTag::create($tag);
        }*/

/*
        $contentHtml = [
            [
                'content_id' => NULL,
                'content_html_tag_id' => 1,
                'label' => 'Type your Text'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 2,
                'label' => 'Type your Text'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 3,
                'label' => 'Type your Text'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 4,
                'label' => 'Type your Text'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 5,
                'label' => 'Type your Text'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 6,
                'data' => '</h1>Type your HTML</h1>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 7,
                'src' => 'http://i.imgur.com/AVqsATi.gif'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 8,
                'text' => '<h1>Title</h1>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 9,
                'text' => '<h2>Title</h2>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 10,
                'text' => '<h3>Title</h3>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 11,
                'text' => '<h4>Title</h4>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 12,
                'text' => '<h5>Title</h5>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 13,
                'text' => '<h6>Title</h6>'
            ],[
                'content_id' => NULL,
                'content_html_tag_id' => 14,
                'text' => '<legend>Legend</legend>'
            ]
        ];

        foreach($contentHtml as $html){
            ContentHtml::create($html);
        }

        DB::commit();*/
        //return response()->json(false);
        
        if($projectId){
            $p = Page::byProject(
                $projectId
            )->getConverted();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'paginate' => $p
            ]);
        }
        
        return response()->json([
            'errors' => 'joeys'
        ], 402);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pages      = $request->input('pages');
        $projectId  = $request->input('project_id');
        $htmlTags   = ContentHtmlTag::all();
        DB::beginTransaction();
        try{        
            foreach($pages as $pageIndex => $page){
                $newPage = new Page;
                $pageCollection = collect($page);
                if(!$pageCollection->has('id')){
                    $pageId = $newPage->create(
                        $pageCollection->merge([
                            'name' => "Page {$pageIndex}",
                            'project_id' => $projectId,
                        ])->forget('rows')->toArray()
                    )->id;
                } else {
                    $pageId = $page['id'];
                }
                $newPage->find($pageId)->update([
                    'position' => $pageIndex
                ]);

                if($pageCollection->has('rows')){
                    foreach($page['rows'] as $rowIndex => $row){
                        $rowCollection = collect($row);
                        $newRow = new Row;
                        if(!$rowCollection->has('id')){
                            $rowId = $newRow->create(
                                $rowCollection->merge([
                                    'page_id' => $pageId,
                                ])->forget('columns')->toArray()
                            )->id;
                        } else {
                            $rowId = $row['id'];
                        }
                        $newRow->find($rowId)->update([
                            'position' => $rowIndex,
                            'grid' => $row['grid'],
                            'page_id' => $pageId
                        ]);

                        if($rowCollection->has('columns')){
                            foreach($row['columns'] as $columnIndex => $column){
                                $columnCollection = collect($column);
                                $newColumn = new Column;
                                if(!$columnCollection->has('id')){
                                    $columnId = $newColumn->create(
                                        $columnCollection->merge([
                                            'row_id' => $rowId,
                                        ])->forget('columns')->toArray()
                                    )->id;
                                } else {
                                    $columnId = $column['id'];
                                }
                                $newColumn->find($columnId)->update([
                                    'position' => $columnIndex
                                ]);

                                if($columnCollection->has('contents')){
                                    foreach($column['contents'] AS $contentIndex => $content){
                                        $contentId = null;
                                        $newContent = new Content;
                                        $contentCollection = collect($content);
                                        $html = $contentCollection['html'];  
                                        //$choices = isset($html['choices'])? $html['choices'] : [];
                                        //dd($html);
                                        if(!$contentCollection->has('id')){
                                            $newContent->column_id = $columnId;
                                            $newContent->save();
                                            $contentId = $newContent->id;
                                        } else {
                                            $contentId = $content['id'];
                                        }

                                        $newRequest = [
                                            'content_id' => $contentId,
                                            'content_html_tag_id' => '',
                                            'content_choice_id' => isset($html['content_choice_id'])? $html['content_choice_id'] : null,
                                            'label' => isset($html['label'])? $html['label'] : '',
                                            'text'  => isset($html['text'])? $html['text'] : '',
                                            'src' => isset($html['src'])? $html['src'] : '',
                                            'data' => isset($html['data'])? $html['data'] : '',
                                        ];

                                        foreach($htmlTags as $tag){
                                            if($html['tag'] == $tag->name){
                                                $newRequest['content_html_tag_id'] = $tag->id;
                                            }
                                        }

                                        $newContentHtml = ContentHtml::create($newRequest);
                                        if(
                                            !$contentCollection->has('id') &&
                                            $newContentHtml->content_html_tag->html_category->id == 1
                                        ){
                                            $table = $content['definition'];
                                            ContentTable::create([
                                                'content_id' => $contentId,
                                                'column_name' => $table['column_name'],
                                                'type' => isset($table['type'])? $table['is_primary_key'] : false,
                                                'is_primary_key' => isset($table['is_primary_key'])? $table['is_primary_key'] : false,
                                                'size' => isset($table['size'])? $table['size'] : null,
                                                'nullable' => isset($table['nullable'])? $table['nullable']: null
                                            ]);
                                        }
                                    
                                        Content::find($contentId)->update([
                                            'position' => $contentIndex,
                                            'column_id' => $columnId
                                        ]);  
                                    }
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            $page = new Page;
            return response()->json([
                'success' => true,
                'message' => 'Adicionado com Sucesso',
                'pages' => Page::byProject($projectId)->getConverted()
            ], 200);                
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'result' => []
            ], 500);
        }

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

    public function updatePosition(Request $request, $projectId)
    {
        //
        $pagePos = $request->input('pagesPos');

        DB::beginTransaction();
        try {
            foreach($pagePos as $i => $pos){
                Page::where('project_id', $projectId)
                ->where('id', $pos)
                ->update([
                    'position' => $i
                ]);
            }
            DB::commit();
            $page = new Page;
            return response()->json([
                'success' => true,
                'message' => 'Adicionado com Sucesso',
                'data' => $page->allPages()
            ], 200);                
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }        
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
        $success = Page::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Deleted"
        ]);
    }

}

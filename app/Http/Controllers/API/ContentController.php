<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use App\Page;
use App\Content;
use App\ContentHtml;
use App\ContentTable;
use App\ContentHtmlTag;
use App\ContentChoice;
use App\ContentChoiceItem;
use App\Column;

use DB;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentRequest $request)
    {
        //
        $contentId      = $request->input("id");
        $contentPos     = $request->input('contentPos');
        $page           = $request->input("page");
        $htmlTags       = ContentHtmlTag::all();

        DB::beginTransaction();
        try{
            $column     = Column::find($request->input('page.currColumnId'));
            $newContent = new Content;

            if($request->filled('id')){
                $newContent->find($contentId)->update([
                    'column_id' => $column->id
                ]);
            } else {
                $newContent->column_id = $column->id;
                $newContent->save();
                $contentId = $newContent->id;

                $newRequest = [
                    'content_id' => $contentId,
                    'content_html_tag_id' => $request->input('html.content_html_tag_id'),
                    'label' => $request->input('html.label'),
                    'text'  => $request->input('html.text'),
                    'src' => $request->input('html.src'),
                    'data' => $request->input('html.data'),
                    'choices' => $request->input('html.choices')
                ];

                foreach($htmlTags as $tag){
                    if($request->input('html.tag') == $tag->name){
                        $newRequest['content_html_tag_id'] = $tag->id;
                    }
                }

                if($request->filled('html.content_choice_id')){
                    $newRequest['content_choice_id'] = $request->input('html.content_choice_id');
                    //$choices = $request->input('html.choices');
                    //if(count($choices) > 0){
                        /*$contentChoiceCreate = ContentChoice::create([
                            'description' => "Description 4"
                        ]);

                        foreach($choices as $i => $choice){
                            if(!array_key_exists('id', $choice)){
                                ContentChoiceItem::create([
                                    'content_choice_id' => $contentChoiceCreate->id,
                                    'text' => $choice['text'],
                                    'value' => $choice['value'],
                                    'position' => $i
                                ]);
                            }    
                        }
                        $newRequest['content_choice_id'] = $contentChoiceCreate->id;*/
                    //}
                }
                $newContentHtml = ContentHtml::create($newRequest);

                if($newContentHtml->content_html_tag->html_category->id == 1){
                    $table = $request->input('definition');
                    ContentTable::create([
                        'content_id' => $contentId,
                        'column_name' => $request->input('table.column_name'),
                        'nullable' => $request->input('table.nullable'),
                        'is_primary_key' => $request->filled('table.is_primary_key')? $request->input('table.is_primary_key') : false
                    ]);
                }                
            }

            foreach($contentPos as $k => $pos){
                $pos = is_null($pos)? $newContent->id : $pos;

                Content::where('column_id', $request->input('page.currColumnId'))
                ->where('id', $pos)
                    ->update([
                        'position' => $k
                    ]);
            }
            DB::commit();
            //$page = new Page;
            return response()->json([
                'success' => true,
                'message' => 'Success'
                //'data' => $page->allPages($request)
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
  
        $content = Content::with('content_html')->with('content_table')->find($id);
        $h = $content->content_html;
        
        $data = [
            'html' => [
                'tag' => !is_null($h->content_html_tag)? $h->content_html_tag->name : '',
                'content_choice_id' => $h->content_choice_id,
                'category' => 'form',
                'choices' => !is_null($h->content_choice)? $h->content_choice->choices_items : [],
                'fields' => [],
                'label' => $h->label,
                'src' => $h->src,
                'text'=> $h->text,
                'data'=> $h->data
            ],
            'definition' => []
        ];
        if($h->content_html_tag->html_category->id == 1){
            if(!is_null($content->content_table)){
                $data['definition'] = [
                    'name' => $content->content_table->column_name,
                    'type' => [
                        'datatype' => $content->content_table->type,
                        'length'=> $content->content_table->size,
                    ],
                    'options' => [
                        'nullable' => (boolean)$content->content_table->nullable
                    ]        
                ];
            }
        }
        
        return response()->json([
        //dd([
            'success' => true,
            'message' => 'message',
            'data' => $data
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
        $html = $request->input("html");
        $table = $request->input("table");
        DB::beginTransaction();

        try{
            $content = Content::find($id);
            if(!is_null($content)){
                unset($html['tag']);
                unset($html['category']);
                unset($html['fields']);
                if(count($request->input('html.choices')) > 0){
                    foreach($request->input('html.choices') as $i => $e){
                        ContentChoiceItem::find($e['id'])->update([
                            'text' => $e['text'],
                            'value' => $e['value']
                        ]);
                    }
                }
                $content->content_html->update($html);
                if($content->content_html->content_html_tag->html_category->id == 1){
                    if(!is_null($content->content_table)){
                        $content->content_table->update($table);
                    }
                }
                DB::commit();
                $c = new Content;
                return response()->json([
                    'success' => true,
                    'message' => 'Success',
                    'data' => $c->getContent($id)
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
        DB::beginTransaction();
        try{
            $content = Content::where('id', $id);
            $content->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success'
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        } 
    }
}

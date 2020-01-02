<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContentChoice;
use App\ContentChoiceItem;
use DB;

class ContentChoiceItemController extends Controller
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
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try{
            $contentChoiceId = -1;
            if($request->filled('content_choice_id')){
                $contentChoiceId = $request->input('content_choice_id');
            } else {
                $contentChoice = ContentChoice::create([
                    'description' => 'balls'
                ]);
                $contentChoiceId = $contentChoice->id;
            }
            
            $content = ContentChoiceItem::create([
                'content_choice_id' => $contentChoiceId,
                'value' => $request->input('value'),
                'text' => $request->input('text')
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => [
                    'contentChoiceId' => $contentChoiceId
                ]
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
        try{
            $content = ContentChoiceItem::find($id);
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => $content
            ]);
        } catch(\Exception $e){

        }
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
        DB::beginTransaction();
        try{
            $content = ContentChoiceItem::find($id)->update(
                $request->except('id', 'content_choice_id')
            );

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => ContentChoiceItem::find($id)
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
            $content = ContentChoiceItem::find($id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Deleted",
                'data' => ContentChoiceItem::find($id)
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

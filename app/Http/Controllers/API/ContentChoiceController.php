<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContentChoice;
use App\ContentChoiceItem;
use DB;

class ContentChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $choices = ContentChoice::convertChoices();
        return response()->json([
            'success' => true,
            'message' => 'any',
            'paginate' => $choices
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
        try {
            $choiceItems = ContentChoiceItem::where('content_choice_id', $id)
            ->orderBy('position', 'ASC')
            ->get();
            
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => $choiceItems
            ]);
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
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
        DB::beginTransaction();
        try {
            $choiceItems = ContentChoiceItem::where('content_choice_id', $id)->get();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => $choiceItems
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateContentChoicesPosition(Request $request, $id){
        $contentChoices = $request->all();

        DB::beginTransaction();
        try {
            $contentChoiceItems = ContentChoiceItem::where('content_choice_id', $id)->get();

            foreach($contentChoices AS $position => $contentChoiceId){
                ContentChoiceItem::find($contentChoiceId)->update([
                    'position' => $position
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "JoeysWorldTour",
                'data' => $choiceItems
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

    
    }
}

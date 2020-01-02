<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RowRequest;
use App\Page;
use App\Column;
use App\Row;
use DB;

class RowController extends Controller
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
    public function store(RowRequest $request)
    {
        //
        $rows = $request->input('rows');
        $rowsPos = $request->input('rowsPos');
        $rowsPos = array_filter($rowsPos, 'strlen');
        $targetPageId = $request->input('page.targetPageId');
        $rowTargetIndex = $request->input('rowTargetIndex');

        DB::beginTransaction();
        try{
            if(count($rows) > 0){
                $rowOrderId = [];
                foreach($rows as $row){
                    $gridArr = explode(" ", $row['grid']);
                    $rowCreate = Row::create([
                        'grid' => implode(" ", $gridArr),
                        'page_id' => $targetPageId
                    ]);
                    $rowOrderId[] = $rowCreate->id;
                    if(count($gridArr) > 0){
                        foreach($gridArr as $grid){
                            Column::create([
                                'row_id' => $rowCreate->id
                            ]);
                        }
                    }
                }
            }

            array_splice($rowsPos, $rowTargetIndex, 0, $rowOrderId);
            if(count($rowsPos) > 0){
                foreach($rowsPos as  $k => $pos){
                    Row::where('page_id', $targetPageId)
                    ->where('id', $pos)
                    ->update([
                        'position' => $k
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => []
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RowRequest $request, $id)
    {
        //
        $targetPageId   = $request->input("page.targetPageId");
        $currRowId      = $request->input("page.currRowId");
        $rowPos         = $request->input("rowPos");

        DB::beginTransaction();
        try {
            Row::where('id', $currRowId)->update([
                'page_id' => $targetPageId
            ]);
            foreach($rowPos as $k => $pos){
                //$pos = is_null($pos)? $newContent->id : $pos;

                Row::where('page_id', $targetPageId)
                ->where('id', $pos)
                    ->update([
                        'position' => $k
                    ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => []
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
    public function destroy($id, Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $row = Row::where('id', $id);
            $row->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => []
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

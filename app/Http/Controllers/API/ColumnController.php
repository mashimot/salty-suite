<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColumnRequest;
use App\Page;
use App\Row;
use App\Column;
use DB;

class ColumnController extends Controller
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
    public function update(ColumnRequest $request, $id)
    {
        //
        $columnPos  = $request->input('columnPos');
        $newGrid    = $request->input('newGrid');
        $currRowId  = $request->input('page.currRowId');

        DB::beginTransaction();
        try
        {
            Row::find($currRowId)->update([
                'grid' => $newGrid
            ]);
            foreach($columnPos as $k => $pos){
                //$pos = is_null($pos)? $newContent->id : $pos;
    
                Column::where('row_id', $request->input('page.currRowId'))
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
    public function destroy($id)
    {
        //
    }
}

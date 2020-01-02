<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page; 
use App\Project;
use DB;

class ProjectController extends Controller
{
    private $perPage = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'paginate' => Project::paginate($this->perPage)
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
        DB::beginTransaction();
        try{
            Project::create($request->all());
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Adicionado com Sucesso',
                'data' => Project::all()
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => Project::find($id)
        ], 200);
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
            Project::find($id)
            ->update([
                'name' => $request->input('name')
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Adicionado com Sucesso',
                'data' => Project::find($id)
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
        DB::beginTransaction();
        try{
            Project::find($id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Adicionado com Sucesso',
                'data' => []
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
}

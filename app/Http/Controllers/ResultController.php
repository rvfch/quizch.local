<?php

namespace App\Http\Controllers;

use App\Result;
use App\Http\Resources\Result as ResultResource;
use Illuminate\Http\Request;
use App\Quiz;

class ResultController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $request->isMethod('put') ? Result::findOrFail($request->id) : new Result;

        $result->quiz_id = $request->input('quiz_id');
        $result->user_id = $request->input('user_id');
        $result->right_answers = $request->input('right_answers');
        $result->isPassed = $request->input('isPassed');

        if($result->save())
            return new ResultResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = Result::where('user_id', $id)->orderBy('id', 'desc')->get();
        return ResultResource::collection($results);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        if($result->delete())
            return new ResultResource($result);
    }
}

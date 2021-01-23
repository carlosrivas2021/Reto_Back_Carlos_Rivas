<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\FeatureInterface;
use App\Models\Skill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillsController extends Controller implements FeatureInterface
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'        => 'required',
                'time_using' => 'required',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }
        try {
            $skill              = new Skill();
            $skill->name        = $request->name;
            $skill->time_using = $request->time_using;
            $skill->user_id     = auth('api')->user()->_id;
            $skill->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $skill,
            'error'   => [],
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                '_id'         => 'required',
                'name'        => 'required',
                'time_using' => 'required',

            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);
        }

        try {
            $skill              = Skill::findOrFail($request->_id);
            $skill->name        = $request->name;
            $skill->time_using = $request->time_using;
            $skill->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $skill,
            'error'   => [],
        ], 200);
    }

    function list() {

        try {
            $skill = Skill::where('user_id', auth('api')->user()->_id)->get();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $skill,
            'error'   => [],
        ], 200);
    }

    public function delete(Request $request)
    {

        try {
            $skill = Skill::findOrFail($request->_id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $skill,
            'error'   => [],
        ], 200);
    }

    public function get(Request $request)
    {

        try {
            $skill = Skill::findOrFail($request->_id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $skill,
            'error'   => [],
        ], 200);
    }
}

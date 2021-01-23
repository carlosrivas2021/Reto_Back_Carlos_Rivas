<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\FeatureInterface;
use App\Models\Experience;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExperienceController extends Controller implements FeatureInterface
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'company'     => 'required',
                'description' => 'required',
                'start_date'  => 'required',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }
        try {
            $experience              = new Experience();
            $experience->company     = $request->company;
            $experience->description = $request->description;
            $experience->start_date  = $request->start_date;
            $experience->user_id     = auth('api')->user()->_id;
            $experience->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $experience,
            'error'   => [],
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                '_id'         => 'required',
                'company'     => 'required',
                'description' => 'required',
                'start_date'  => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);
        }

        try {
            $experience              = Experience::findOrFail($request->_id);
            $experience->company     = $request->company;
            $experience->description = $request->description;
            $experience->start_date  = $request->start_date;
            $experience->end_date    = $request->end_date ? $request->end_date : null;
            $experience->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $experience,
            'error'   => [],
        ], 200);
    }

    function list() {

        try {
            $experience = Experience::where('user_id', auth('api')->user()->_id)->get();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $experience,
            'error'   => [],
        ], 200);
    }

    public function delete(Request $request)
    {

        try {
            $experience = Experience::findOrFail($request->_id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $experience,
            'error'   => [],
        ], 200);
    }

    public function get(Request $request)
    {

        try {
            $experience = Experience::findOrFail($request->_id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $experience,
            'error'   => [],
        ], 200);
    }
}

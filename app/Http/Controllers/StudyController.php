<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\FeatureInterface;
use App\Models\Study;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyController extends Controller implements FeatureInterface
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'academy'     => 'required',
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
            $study              = new Study();
            $study->academy     = $request->academy;
            $study->description = $request->description;
            $study->start_date  = $request->start_date;
            $study->end_date    = $request->end_date ? $request->end_date : null;
            $study->user_id     = auth('api')->user()->_id;
            $study->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $study,
            'error'   => [],
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                '_id'         => 'required',
                'academy'     => 'required',
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
            $study              = Study::findOrFail($request->_id);
            $study->academy     = $request->academy;
            $study->description = $request->description;
            $study->start_date  = $request->start_date;
            $study->end_date    = $request->end_date ? $request->end_date : null;
            $study->save();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $study,
            'error'   => [],
        ], 200);
    }

    function list() {

        try {
            $study = Study::where('user_id', auth('api')->user()->_id)->get();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $study,
            'error'   => [],
        ], 200);
    }

    public function delete(Request $request)
    {

        try {
            $study = Study::findOrFail($request->_id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $study,
            'error'   => [],
        ], 200);
    }

    public function get(Request $request)
    {

        try {
            $study = Study::findOrFail($request->_id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => [$e->getMessage()],
            ], 503);
        }

        return response()->json([
            'success' => true,
            'data'    => $study,
            'error'   => [],
        ], 200);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\StudyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function experience(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'type' => 'required',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }
        $type = $request->type;

        $experience = new ExperienceController();
        return $experience->$type($request);
    }

    public function study(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'type' => 'required',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }
        $type = $request->type;

        $study = new StudyController();
        return $study->$type($request);
    }

    public function skill(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'type' => 'required',
            ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'data'    => '',
                'error'   => $validator->errors(),
            ], 401);

        }
        $type = $request->type;

        $study = new SkillsController();
        return $study->$type($request);
    }

}

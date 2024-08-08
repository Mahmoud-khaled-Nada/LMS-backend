<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;


class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $rules = [
            'course_id'                 => 'required|exists:courses,id',
        ];

        $messages = [
            'course_id.required'        => __('lang.course_id-required') ,
            'course_id.exists'          => __('lang.course_id-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $student            = auth('student')->user();
        $subscription       = Subscribe::where('student_id', $student->id)
                                    ->where('course_id', $request->course_id)
                                    ->first();

        if ($subscription) {
            return response()->json( [
                'status'  => 'true',
                'message' => __('lang.course_subs_before')
            ], 400);
        }

        // Creating the subscription
        $course = Course::find($request->course_id);
        $student->courses()->attach($course->id);

        return response()->json([
            'status'  => 'true',
            'message' => __('lang.course_subscribe')
        ], 200 );
    }
}

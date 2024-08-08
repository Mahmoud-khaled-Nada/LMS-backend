<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\InstructorReview;
use GuzzleHttp\Psr7\Response;

class InstructorController extends Controller
{
    public function instructors(Request $request)
    {
        $categoryId     = $request->input('category_id');
        $instructors    = User::role('teacher')->with('reviews')
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->withCount('courses')
            ->get();

        return response()->json([
            'status'        => 'true',
            'instructors'   => $instructors
        ], 200);
    }

    public function instructorReviews( Request $request )
    {
        $rules = [
            'user_id' => [
                'required',
                'exists:users,id',
                    function ( $attribute , $value, $fail ) {
                        $user = User::find($value);
                        if (!$user || !$user->hasRole('teacher')) {
                            $fail('The selected user must have the role of teacher.');
                        }
                },
            ],
            'rating' => 'required|in:1,2,3,4,5',
            'review' => 'required'
        ];

        $messages = [
            'user_id.required'          => __('lang.user_id-required') ,
            'user_id.exists'            => __('lang.user_id-exists'),
            'rating.required'           => __('lang.rating-required'),
            'rating.in'                 => __('lang.rating-in'),
            'review.required'           => __('lang.review-required')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $clientId = auth('student')->user()->id;
        $data = InstructorReview::create([
            'user_id'       => $request->user_id,
            'student_id'    => $clientId,
            'rating'        => $request->rating,
            'review'        => $request->review
        ]);

        $averageRate =  InstructorReview::where('user_id', $request->user_id)->avg('rating');
        $reviewCount =  InstructorReview::where('user_id', $request->user_id)->count();

        // Update in Course
        $course     = User::find($request->user_id);
        $course->average_rate   = $averageRate;
        $course->count          = $reviewCount;
        $course->save();

        return response()->json([
            'staus'     => 'true',
            'data'      => $data ,
            'Message'   => __('lang.review-added')
        ] , 200 );

    }

    public function getInstructorById(Request $request )
    {
        $rules = [
            'user_id' => [
                'required',
                'exists:users,id',
                    function ( $attribute , $value, $fail ) {
                        $user = User::find($value);
                        if (!$user || !$user->hasRole('teacher')) {
                            $fail('The selected user must have the role of teacher.');
                        }
                },
            ],
        ];

        $messages = [
            'user_id.required'          => __('lang.user_id-required') ,
            'user_id.exists'            => __('lang.user_id-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $instructor = User::with('reviews' , 'courses')->withCount('courses')->role('teacher')
                            ->where('id' , $request->user_id )->first();
        return Response()->json([
            'status'        => 'true',
            'instructor'    => $instructor
        ] , 200 );
    }

    public function searchInstructor()
    {
        $instructors = User::with('category')
                        ->withCount('courses')
                        ->role('teacher')
                        ->when(request('name'), function ($query, $name) {
                            return $query->where('name', 'like', '%' . $name . '%');
                        })
                        ->orderBy('average_rate', 'desc')
                        ->paginate(10);
        return response()->json([
            'status'         => 'true' ,
            'instructors'    => $instructors ,
        ], 200);

    }

    public function instructorsPaginate()
    {
        $instructors    = User::with('category')->withCount('courses')->role('teacher')
                                ->orderBy('average_rate', 'desc')->paginate(10);
        return response()->json([
            'status'        => 'true',
            'instructors'   => $instructors
        ], 200);
    }
}

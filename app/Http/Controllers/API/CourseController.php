<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Subscribe;

class CourseController extends Controller
{
    public function courses()
    {
            // جلب البيانات الأساسية مع العد
            $baseQuery = Course::with('instructor', 'lessons.lectures')
                ->withCount('lessons');

            // جلب الكورسات الجديدة
            $newCourses = (clone $baseQuery)
                ->orderBy('created_at', 'desc')
                ->get();

            // جلب الكورسات الأكثر شعبية
            $mostPopular = (clone $baseQuery)
                ->orderBy('average_rate', 'desc')
                ->get();

            return response()->json([
                'status'        => 'true',
                'new'           => $newCourses,
                'most_popular'  => $mostPopular
            ], 200);
    }

    public function createReview( Request $request )
    {
        $rules = [
            'course_id'         => 'required|exists:courses,id',
            'rating'            => 'required|in:1,2,3,4,5',
            'review'            => 'required'
        ];

        $messages = [
            'course_id.required'        => __('lang.course_id-required') ,
            'course_id.exists'          => __('lang.course_id-exists'),
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

        $isSubscribed = Subscribe::where('student_id', $clientId)
                        ->where('course_id', $request->course_id)
                        ->exists();

    if (!$isSubscribed) {
        return response()->json([
            'status'  => 'failed',
            'message' => __('lang.not_subscribed_to_course')
        ], 403);
    }
        $data = CourseReview::create([
            'course_id'     => $request->course_id,
            'student_id'    => $clientId,
            'rating'        => $request->rating,
            'review'        => $request->review
        ]);

        $averageRate =  CourseReview::where('course_id', $request->course_id)->avg('rating');
        $reviewCount =  CourseReview::where('course_id', $request->course_id)->count();
        // Update in Course
        $course     = Course::find($request->course_id);
        $course->average_rate   = round($averageRate);
        $course->count          = $reviewCount;
        $course->save();

        return response()->json([
            'staus'     => 'true',
            'data'      => $data ,
            'Message'   => __('lang.review-added')
        ] , 200 );
    }

    public function filterByRating(Request $request)
    {
          // قواعد التحقق
        $rules = [
            'rating'             => 'sometimes|in:1,2,3,4,5',
            'user_ids'           => 'nullable|array',
            'user_ids.*'         => 'exists:users,id',
            'min_price'          => 'nullable|numeric|min:0',
            'max_price'          => 'nullable|numeric|min:0',
            'category_ids'       => 'nullable|array',
            'category_ids.*'     => 'exists:categories,id',
        ];

        // رسائل الخطأ
        $messages = [
            'rating.required'       => __('lang.rating-required'),
            'rating.in'             => __('lang.rating-in'),
            'user_ids.array'        => __('lang.user_ids-array'),
            'user_ids.*.exists'     => __('lang.user_id-exists'),
            'min_price.numeric'     => __('lang.min_price-numeric'),
            'min_price.min'         => __('lang.min_price-min'),
            'max_price.numeric'     => __('lang.max_price-numeric'),
            'max_price.min'         => __('lang.max_price-min'),
            'category_ids.array'    => __('lang.category_ids-array'),
            'category_ids.*.exists' => __('lang.category_id-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'failed',
                'message' => $validator->errors()->first(),
            ], 422);
        }

     // بناء الاستعلام الأساسي
        $query = Course::query();

        $query->when($request->filled('rating'), function ($q) use ($request) {
            return $q->where('average_rate', $request->input('rating'));
        });

        $query->when($request->filled('user_ids'), function ($q) use ($request) {
            return $q->whereIn('user_id', $request->input('user_ids'));
        });

        $query->when($request->filled('min_price') && $request->filled('max_price')
                , function ($q) use ($request) {
            return $q->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        });

        $query->when($request->filled('category_ids'), function ($q) use ($request) {
            return $q->whereIn('category_id', $request->input('category_ids'));
        });

        // جلب النتائج
        // $courses = $query->get();
        $courses = $query->paginate(10);

        return response()->json([
            'status'  => 'true',
            'courses' => $courses
        ], 200);
    }


    public function  coursesByCategory( Request $request )
    {
        $rules =  [
            'category_id'             => 'required|exists:categories,id' ,
        ];

        $messages = [
            'category_id.required'    => __('lang.category_id.required'),
            'category_id.exists'      => __('lang.category_id-exists'),
        ];

        // إجراء التحقق
        $validator = Validator::make($request->all(), $rules, $messages);

        // التحقق من الفشل
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'failed',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // // جلب البيانات الأساسية مع العد
        $baseQuery = Course::with('instructor.category', 'lessons.lectures')
                        ->withCount('lessons')->where('category_id' , $request->category_id);

        // جلب الكورسات الجديدة
        $newCourses = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->get();

        // جلب الكورسات الأكثر شعبية
        $mostPopular = (clone $baseQuery)
            ->orderBy('average_rate', 'desc')
            ->get();

            return response()->json([
                'status'                => 'true',
                'new-courses'           => $newCourses ,
                'mostPopular-courses'   => $mostPopular ,
            ], 200 );
    }

    public function courseById( Request $request )
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

        // $course  = Course::with('instructor.courses' , 'lessons.lectures' , 'reviews')
        //             ->where('id' , $request->course_id)->first();

        $course = Course::with( ['instructor' => function($query) {
                        $query->with( ['courses' => function($query) {
                                $query->take(5);
                    }]);
        }, 'lessons.lectures', 'reviews'])->where('id', $request->course_id)->first();

        return response()->json([
            'status'   => 'true' ,
            'course'   =>  $course
        ] , 200 );
    }

}

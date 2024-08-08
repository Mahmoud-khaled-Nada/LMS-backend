<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\PackageStudent;

class PacakageContrller extends Controller
{
    public function packageById( Request $request )
    {
        $rules = [
            'package_id'                 => 'required|exists:packages,id',
        ];

        $messages = [
            'package_id.required'        => __('lang.package_id-required') ,
            'package_id.exists'          => __('lang.package_id-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $package  = Package::with('courses' , 'reviews')
                        ->where('id' , $request->package_id)->first();

        return response()->json([
            'status'     => 'true' ,
            'package'    =>  $package
        ] , 200 );
    }

    public function packageReview( Request $request )
    {
        $rules = [
            'package_id'        => 'required|exists:packages,id',
            'rating'            => 'required|in:1,2,3,4,5',
            'review'            => 'required'
        ];

        $messages = [
            'package_id.required'        => __('lang.package_id-required') ,
            'package_id.exists'          => __('lang.package_id-exists'),
            'rating.required'            => __('lang.rating-required'),
            'rating.in'                  => __('lang.rating-in'),
            'review.required'            => __('lang.review-required')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $clientId       = auth('student')->user()->id;
        $isSubscribed  = PackageStudent::where( 'student_id', $clientId )
                            ->where( 'package_id', $request->package_id )
                            ->exists();

        if (!$isSubscribed) {
                return response()->json([
                'status' => 'failed',
                'message' => __('lang.not-subscribed'),
                ], 403);
        }

        $data = PackageReview::create([
            'package_id'    => $request->package_id,
            'student_id'    => $clientId,
            'rating'        => $request->rating,
            'review'        => $request->review
        ]);

        $averageRate =  PackageReview::where('package_id', $request->package_id)->avg('rating');
        $reviewCount =  PackageReview::where('package_id', $request->package_id)->count();
        // Update in Course
        $course     = Package::find($request->package_id);
        $course->average_rate   = round($averageRate);
        $course->count          = $reviewCount;
        $course->save();

        return response()->json([
            'staus'     => 'true',
            'data'      => $data ,
            'Message'   => __('lang.review-added')
        ] , 200 );
    }

    public function subscribe(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $rules = [
            'package_ids'       => 'required|array',
            'package_ids.*'     => 'exists:packages,id',
        ];

        $messages = [
            'package_id.required'        => __('lang.package_id-required') ,
            'package_id.exists'          => __('lang.package_id-exists'),
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $student                = auth('student')->user();
        $alreadySubscribed      = $student->subscribe($request->package_ids);

        return response()->json([
            'message'               => 'Subscription successful',
            'already_subscribed'    => $alreadySubscribed
        ]);
    }

    public function packagePaginate()
    {
        $packages       = Package::withCount('courses')->paginate(10);
        return response()->json([
            'status'     => 'true' ,
            'package'    =>  $packages
        ] , 200 );
    }
}

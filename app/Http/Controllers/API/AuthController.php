<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Mail\SignupCode;

class AuthController extends Controller
{
    // public function signup(Request $request)
    // {
    //     $validator = Validator::make($request->all(), Student::$rules);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'        => 'failed',
    //             'message'       => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $student = $validator->validated();
    //     $student = Student::create($student);
    //     $student->status = '0';

    //     $code               = mt_rand(100000, 999999);
    //     $expireTime         = Carbon::now()->addMinutes(5);

    //     $student->code      = $code;
    //     $student->expire    = $expireTime;
    //     $student->save();

    //     Mail::to( $student->email )->send( new SignupCode($code) );

    //     return response()->json([
    //         'status'    => 'success',
    //         'message'   => 'Signup successful. Please check your email for the verification code.',
    //     ], 200);
    // }

    // public function confirmSignupCode(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'code' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => $validator->errors()->first(),
    //         ], 422);
    //     }

    //     $user = Student::where('code', $request->code)->first();
    //     if (!$user || $user->code != $request->code) {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => 'Invalid Code',
    //         ], 403);
    //     }

    //     $current_time = Carbon::now();
    //     if ($current_time->greaterThan($user->expire)) {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => 'Code Expired',
    //         ], 403);
    //     }

    //     $user->status   = '1'; // Activate the user
    //     $user->code     = null;
    //     $user->expire   = null;
    //     $user->save();

    //     $token = Auth::guard('student')->login($user);

    //     return response()->json([
    //         'status'  => 'success',
    //         'message' => 'Code confirmed and logged in successfully.',
    //         'token'   => $token,
    //         'user'    => $user,
    //     ], 200);
    // }


    // public function login()
    // {
    //     $validator = Validator::make(request()->all(), [
    //         'email'         => 'required|string',
    //         'password'      => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'   => 'failed',
    //             'message'  => $validator->errors()->first()
    //         ], 422);
    //     }
    //     $credentials = request( ['email', 'password'] );

    //     if (!$token = auth('student')->attempt($credentials)) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => __('auth.failed')
    //         ], 422);
    //     } else {
    //         // $student = auth('student')->user()->first();
    //         $student  = auth('student')->user();

    //         $data['token'] = $token;
    //         return response()->json([
    //             'status'    => 'success',
    //             'Student'   => $student,
    //             'data'      => $data,
    //         ], 200);
    //     }
    // }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), Student::$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'        => 'failed',
                'message'       => $validator->errors()->first()
            ], 422);
        }

        $student = $validator->validated();
        $student = Student::create($student);
        $student->status = '0';

        $code               = mt_rand(100000, 999999);
        $expireTime         = Carbon::now()->addMinutes(5);

        $student->code      = $code;
        $student->expire    = $expireTime;
        $student->save();

        Mail::to($student->email)->send(new SignupCode($code));

        return response()->json([
            'status'    => 'success',
            'message'   => 'Signup successful. Please check your email for the verification code.',
        ], 200);
    }

    public function confirmSignupCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'failed',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Student::where('code', $request->code)->first();
        if (!$user || $user->code != $request->code) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid Code',
            ], 403);
        }

        $current_time = Carbon::now();
        if ($current_time->greaterThan($user->expire)) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Code Expired',
            ], 403);
        }

        $user->status               = '1'; // Activate the user
        $user->code                 = null;
        $user->expire               = null;
        $user->email_verified_at    = Carbon::now(); // Add verification timestamp
        $user->save();

        $token = Auth::guard('student')->login($user);

        return response()->json([
            'status'  => 'success',
            'message' => 'Code confirmed and logged in successfully.',
            'token'   => $token,
            'user'    => $user,
        ], 200);
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email'         => 'required|string',
            'password'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'failed',
                'message'  => $validator->errors()->first()
            ], 422);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth('student')->attempt($credentials)) {
            return response()->json([
                'status'     => 'failed',
                'message'    => __('auth.failed')
            ], 422);
        }

        // $student = auth('student')->user();
        $student = auth('student')->user()->load('courses', 'packages', 'books');

        if ( is_null($student->email_verified_at) ) {
            // إعادة إرسال الكود إذا لم يتم التحقق من البريد الإلكتروني
            $code = mt_rand(100000, 999999);
            $expireTime = Carbon::now()->addMinutes(5);
            $student->code = $code;
            $student->expire = $expireTime;
            $student->save();

            Mail::to($student->email)->send(new SignupCode($code));

            return response()->json([
                'status'  => 0,
                'message' => 'Email not verified. A new verification code has been sent to your email.',
            ], 403);
        }

        $data['token'] = $token;
        return response()->json([
            'status'    => 'success',
            'Student'   => $student,
            'data'      => $data,
        ], 200);
    }


    public function profile()
    {
        $student = auth('student')->user();
        return response()->json( [
            'status' => 'success',
            'data'   => auth('student')->user()
        ], 200 );
    }


    public function updateProfile(Request $request)
    {
        $rules = Student::$rules;
        $rules['name']                  = 'sometimes|string|max:255';
        $rules['phone']                 = 'sometimes';
        $rules['email']                 = 'sometimes|string';
        $rules['image']                 = 'nullable|image|mimes:jpeg,png,jpg';
        $rules['gender']                = 'sometimes|in:male,female';
        $rules['password']              = 'sometimes|string|min:8';
        $rules['password_confirmation'] = 'required_with:password|same:password';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $student = auth('student')->user();

        $validatedData = $validator->validated();
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image');
        }

            $student->update($validatedData);

            return response()->json( [
                'status' => 'success',
                'data'   => $student,
            ], 200);
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'current_password'          => 'required',
            'new_password'              => 'required|min:8|confirmed',
        ];

        $messages = [
            'current_password.required' => __('auth.current_password-required'),
            'new_password.required'     => __('auth.new_password-required'),
            // 'new_password.min'          => __('auth.new_password-min'),
            'new_password.confirmed'    => __('auth.new_password-confirmed'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ], 422);
        }

        //  Get User
        $user = auth('student')->user();

        // Check Password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => __('auth.current_password_incorrect'),
            ], 422);
        }

        // Update Password
        // $user->password = Hash::make($request->new_password);
        $user->password = $request->new_password;
        $user->save();

        return response()->json([
            'status'    => 'success',
            'message'   => __('auth.password_changed'),
        ], 200);
    }

    public function forgotPassword( Request $request )
    {
        $rules = [
            'email'     => 'required',
        ];

        $validator = Validator::make( $request->all() , $rules );
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'failed',
                'message' => $validator->errors()->first(),
            ], 422 );
        }

        $email  = $request->email;
        $user   = Student::where('email', $email )->first();
        if (!$user) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'This Email Not Found' ,
            ], 404 );
        }

        $code                   = mt_rand(100000, 999999);         // Generating a 6-digit OTP
        $expireTime             = Carbon::now()->addMinutes(3);
        $user->update( [
            'code'       => $code ,
            'expire'     => $expireTime ,
        ] );

        Mail::to( $user->email )->send( new forgetpassword($code) );
        // Mail::to( 'osama.m.yousry.98@gmail.com' )->send( new forgetpassword($code) );

        return response()->json([
            'status'  => 'true',
            'message' => 'Check Your Email' ,
        ], 200 );
    }

    // public function ConfrimCode( Request $request )
    // {
    //     $rules = [
    //         // 'email'         => 'required',
    //         'code'          => 'required', // تأكد من وجود الكود في الطلب
    //         // 'password'      => 'required|min:8',
    //     ];

    //     $validator = Validator::make( $request->all() , $rules );
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => $validator->errors()->first(),
    //         ], 422 );
    //     }

    //     $user = Student::where('code', $request->code)->first();
    //     // if (!$user)
    //     // {
    //     //     return response()->json([
    //     //         'status'  => 'failed',
    //     //         'message' => 'This Email Not Found' ,
    //     //     ], 404 );
    //     // }

    //     if  ($user->code != $request->code )
    //     {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => 'Nvalid Code' ,
    //         ], 403 );
    //     }

    //     // check expire time of code
    //     $current_time = Carbon::now();
    //     if ($current_time->greaterThan($user->expire)) {
    //         return response()->json([
    //             'status'  => 'failed',
    //             'message' => 'Code Expired',
    //         ], 403);
    //     }

    //     $token = Auth::guard('student')->login($user);

    //     return response()->json([
    //         'status'  => 'success',
    //         'message' => 'Confirm Code Successfully and Logged In',
    //         'token'   => $token,
    //     ], 200);

    //     // $user->update( [
    //     //     'password'  => $request->password ,
    //     //     'code'      => null ,
    //     //     'expire'    => null,
    //     // ]);

    //     // return response()->json([
    //     //     'status'  => 'true',
    //     //     'message' => 'Password Updated Successfully' ,
    //     // ], 200 );
    // }
    public function ConfrimCode(Request $request)
    {
            $rules = [
                'code' => 'required', // تأكد من وجود الكود في الطلب
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $user = Student::where('code', $request->code)->first();
            if (!$user || $user->code != $request->code) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Invalid Code',
                ], 403);
            }

        // تحقق من انتهاء صلاحية الكود
            $current_time = Carbon::now();
            if ($current_time->greaterThan($user->expire)) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Code Expired',
                ], 403);
            }

            $token = Auth::guard('student')->login($user);

            return response()->json([
                'status'  => 'success',
                'message' => 'Confirm Code Successfully and Logged In',
                'token'   => $token,
            ], 200);
    }

    public function confirmPassword(Request $request)
    {
        $rules = [
            'password'      => 'required|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'failed',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Token not provided',
            ], 401);
        }

         $user = Auth::guard('student')->setToken($token)->user();
        if (!$user) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid token or user not authenticated',
            ], 401);
        }

        $user->update([
            'password' => $request->password,
            'code'     => null,
            'expire'   => null,
        ]);

        return response()->json([
            'status'  => 'true',
            'message' => 'Password Updated Successfully',
        ], 200);
    }

    public function updateFCMToken(Request $request)
    {
        $student = auth('student')->user();
        $student->update(['fcm_token' => $request->fcm_token]);
        return response()->json([
            'status' => 'success',
            'message' => __('lang.success'),
            'data'    => $student
        ], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status'   => 'success',
            'message'  => __('lang.logout'),
        ], 200);
    }


}

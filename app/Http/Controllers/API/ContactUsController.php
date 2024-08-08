<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function contactUs( Request $request )
    {
        $rules = [
            'name'      => 'required' ,
            'email'     => 'required' ,
            'title'     => 'required' ,
            'message'   => 'required'
        ];
        $messages = [
            'name.required'            => __('lang.name-required') ,
            'email.required'           => __('lang.email-required'),
            'title.required'           => __('lang.title-required') ,
            'message.required'         => __('_lang.message-required')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $data = ContactUs::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'title'         => $request->title,
            'message'       => $request->message
        ]);

        return response()->json([
            'staus'     => 'true',
            'data'      => $data ,
            'Message'   => __('lang.contact-added')
        ] , 200 );
    }
}

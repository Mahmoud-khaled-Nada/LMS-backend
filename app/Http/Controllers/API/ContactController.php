<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contact()
    {
        $contact = Contact::all();
        return response()->json( [
            'status'   => 'true' ,
            'contact'  => $contact
        ] ,200 );
    }
}

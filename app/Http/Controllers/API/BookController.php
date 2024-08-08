<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\Student;

class BookController extends Controller
{
    public function bookById( Request $request )
    {
        $rules = [
            'book_id'                 => 'required|exists:books,id',
        ];

        $messages = [
            'book_id.required'        => __('lang.book_id-required') ,
            'book_id.exists'          => __('lang.book_id-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $book  = Book::with('reviews')->where('id' , $request->book_id)->first();

        return response()->json([
            'status'     => 'true' ,
            'book'       =>  $book
        ] , 200 );
    }

    public function createBookReview(Request $request)
    {
        $rules = [
            'book_id'           => 'required|exists:books,id',
            'rating'            => 'required|in:1,2,3,4,5',
            'review'            => 'required'
        ];

        $messages = [
            'book_id.required'          => __('lang.book_id-required') ,
            'book_id.exists'            => __('lang.book_id-exists'),
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

        $student = auth('student')->user();
        // التحقق مما إذا كان الطالب اشترى الكتاب
        $hasBought = $student->books()->where('book_id', $request->book_id)->exists();

        if (!$hasBought) {
            return response()->json([
                'status'  => 'failed',
                'message' => __('lang.not_bought_book')
            ], 403);
        }

        $data = BookReview::create([
            'book_id'       => $request->book_id,
            'student_id'    => $student->id,
            'rating'        => $request->rating,
            'review'        => $request->review
        ]);

        $averageRate =  BookReview::where('book_id', $request->book_id)->avg('rating');
        $reviewCount =  BookReview::where('book_id', $request->book_id)->count();
        // Update in Book
        $course     = Book::find($request->book_id);
        $course->average_rate   = $averageRate;
        $course->count          = $reviewCount;
        $course->save();

        return response()->json([
            'staus'     => 'true',
            'data'      => $data ,
            'Message'   => __('lang.review-added')
        ] , 200 );
    }

    public function buyBooks(Request $request)
    {
        $rules = [
            'book_ids'                  => 'required|array|min:1',
            'book_ids.*'                => 'required|exists:books,id',
        ];

        $messages = [
            'book_ids.required'         => __('lang.book_ids-required') ,
            'book_ids.exists'           => __('lang.book_ids-exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( [
                'status'    => 'failed',
                'message'   => $validator->errors()->first(),
            ] , 422 );
        }

        $student = auth('student')->user();
        if (!$student) {
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Student not found'
            ], 404);
        }

        $bookIds        = $request->book_ids;
        // Buy Books
        $alreadyBought = $student->buyBooks($bookIds);

        if (!empty($alreadyBought)) {
            return response()->json([
                'status'                    => 'partial',
                'message'                   => 'Some books were already bought',
                'already_bought_book_ids'   => $alreadyBought
            ], 200);
        }

        return response()->json([
            'status'         => 'true',
            'message'        => 'Books purchased successfully'
        ], 200);
    }

    public function bookPaginate()
    {
        $books          = Book::withCount(['students as seller'])->paginate(10);
        return response()->json([
            'status'     => 'true' ,
            'book'       =>  $books
        ] , 200 );
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Book;
use App\Models\Package;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function order(Request $request)
    {
        $user       = Auth::user();
        $student    = Student::find($user->id);

        $bookIds        = $request->input('books', []);
        $courseIds      = $request->input('courses', []);
        $packageIds     = $request->input('packages', []);

        // التحقق وشراء الكتب
        $validBookIds   = Book::whereIn('id', $bookIds)->pluck('id')->toArray();
        $invalidBookIds = array_diff($bookIds, $validBookIds);
        $alreadyBoughtBooks = $student->books()->whereIn('book_id', $validBookIds)
                                ->pluck('book_id')->toArray();
        $newBooks           = array_diff($validBookIds, $alreadyBoughtBooks);
        $newBookDetails     = Book::whereIn('id', $newBooks)->get();
        if (!empty($newBooks)) {
            $student->books()->attach($newBooks);
            foreach ($newBooks as $bookId) {
                Order::create([
                    'student_id' => $student->id,
                    'item_id'    => $bookId,
                    'item_type'  => 'book'
                ]);
            }
        }

        // التحقق والاشتراك في الدورات
        $validCourseIds     = Course::whereIn('id', $courseIds)->pluck('id')->toArray();
        $invalidCourseIds   = array_diff($courseIds, $validCourseIds);
        $alreadySubscribedCourses = $student->courses()->whereIn('course_id', $validCourseIds)
                                        ->pluck('course_id')->toArray();
        $newCourses         = array_diff($validCourseIds, $alreadySubscribedCourses);
        $newCourseDetails   = Course::whereIn('id', $newCourses)->get();
        if (!empty($newCourses)) {
            $student->courses()->attach($newCourses);
            foreach ($newCourses as $courseId) {
                Order::create([
                    'student_id' => $student->id,
                    'item_id'    => $courseId,
                    'item_type'  => 'course'
                ]);
            }
        }

        // التحقق والاشتراك في الحزم
        $validPackageIds    = Package::whereIn('id', $packageIds)->pluck('id')->toArray();
        $invalidPackageIds  = array_diff($packageIds, $validPackageIds);
        $alreadySubscribedPackages = $student->packages()->whereIn('package_id', $validPackageIds)
                                    ->pluck('package_id')->toArray();
        $newPackages               = array_diff($validPackageIds, $alreadySubscribedPackages);
        $newPackageDetails         = Package::whereIn('id', $newPackages)->get();
        if (!empty($newPackages)) {
            $student->packages()->attach($newPackages);
            foreach ($newPackages as $packageId) {
                Order::create([
                    'student_id'    => $student->id,
                    'item_id'       => $packageId,
                    'item_type'     => 'package'
                ]);
            }
        }

        return response()->json([
            'status'                        => 'true',
            'new_books'                     => $newBookDetails,
            'already_bought_books'          => Book::whereIn('id', $alreadyBoughtBooks)->get(),
            'invalid_books'                 => $invalidBookIds,
            'new_courses'                   => $newCourseDetails,
            'already_subscribed_courses'    => Course::whereIn('id', $alreadySubscribedCourses)->get(),
            'invalid_courses'               => $invalidCourseIds,
            'new_packages'                  => $newPackageDetails,
            'already_subscribed_packages'   => Package::whereIn('id', $alreadySubscribedPackages)->get(),
            'invalid_packages'              => $invalidPackageIds,
        ], 200);
    }
}

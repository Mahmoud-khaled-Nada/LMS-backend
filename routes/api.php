<?php


use App\Http\Controllers\API\ExcursionController;
use App\Http\Controllers\API\AgeController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CruiseReviewController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\TermController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InstructorController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\PacakageContrller;
use App\Http\Controllers\API\SubscriberController;
use App\Http\Controllers\API\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::middleware(['auth:user','StatusMiddleware'])->group(function(){
//     Route::get('profile', [AuthController::class, 'Profile']);
//     Route::post('update-profile', [AuthController::class, 'UpdateProfile']);
//     Route::get('logout', [AuthController::class, 'Logout']);
//     Route::post('change-password', [AuthController::class, 'ChangePassword']);
//     Route::post('cruise/add-or-update-review',[CruiseReviewController::class,'addOrUpdateReview']);


// });



Route::post('login', [AuthController::class, 'login'])->middleware('checkEmailVerified');
Route::post('signup', [AuthController::class, 'signup']);
Route::post('confirmSignupCode', [AuthController::class, 'confirmSignupCode']);
Route::Post('forgetPassword' ,  [ AuthController::class , 'forgotPassword']  );
Route::Post('confrimCode' , [ AuthController::class , 'ConfrimCode'] );
Route::Post('confrimPassword' , [ AuthController::class , 'confirmPassword'] );

Route::group(  ['middleware' => ['auth:student'] ] ,  function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('profile', [AuthController::class, 'updateProfile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('fcm-token', [AuthController::class, 'updateFCMToken']);

        Route::post('create-revirew-course' , [ CourseController::class , 'createReview'] );
        Route::post('create-revirew-package' , [ PacakageContrller::class , 'packageReview'] );
        Route::post('create-revirew-instructor' , [ InstructorController::class , 'instructorReviews'] );
        Route::post('create-revirew-books' , [ BookController::class , 'createBookReview'] );

        // Subscribe
        Route::post('buy-books' , [ BookController::class , 'buyBooks'] );
        Route::post('subscribe', [ SubscriberController::class, 'subscribe']);
        Route::post('subscribe-package', [ PacakageContrller::class, 'subscribe'] );

        // Create Order
        Route::post('order', [ OrderController::class , 'order'] );
});


Route::post('courses/filter', [CourseController::class, 'filterByRating']);
Route::post('courses/filter/bycaregory', [CourseController::class, 'coursesByCategory']);


Route::get('home' ,  [ HomeController::class , 'homePage' ] );
Route::get('categories' , [ CategoryController::class , 'categories'] );

Route::get('courses' , [ CourseController::class , 'courses'] );
Route::post('courseById' , [ CourseController::class , 'courseById'] );

Route::post('packageById' , [ PacakageContrller::class , 'packageById'] );
Route::get('package-paginate' , [ PacakageContrller::class , 'packagePaginate'] );


Route::post('bookById' , [ BookController::class , 'bookById'] );
Route::get('book-paginate' , [ BookController::class , 'bookPaginate'] );


Route::get('questions',  [ QuestionController::class , 'questions' ] ) ;
Route::get('terms',  [ TermController::class , 'terms' ] ) ;
Route::get('contact' , [ ContactController::class , 'contact'] );
Route::get('settings' , [ SettingController::class , 'setting'] );
Route::post('contact-us' , [ ContactUsController::class , 'contactUs'] );


Route::get('instructors' , [ InstructorController::class , 'instructors'] );
Route::get('instructors-paginate' , [ InstructorController::class , 'instructorsPaginate'] );
Route::post('instructorById' , [ InstructorController::class , 'getInstructorById'] );
Route::post('serach-instructor' , [ InstructorController::class , 'searchInstructor'] );



// Route::group([

//     'middleware'  => 'api',
//     'prefix'      => 'auth'

// ], function () {


//     Route::group(['middleware' => ['auth:student']], function () {
//         Route::get('logout', [AuthController::class, 'logout']);
//         Route::get('profile', [AuthController::class, 'profile']);
//         Route::post('profile', [AuthController::class, 'updateProfile']);
//         Route::post('fcm-token', [AuthController::class, 'updateFCMToken']);
//     });
// });




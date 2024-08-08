<?php


use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\AdminPanel\AuthController;
use App\Http\Controllers\AdminPanel\PermessionController;
use App\Http\Controllers\AdminPanel\RoleController;
use App\Http\Controllers\AdminPanel\SettingController;
use App\Http\Controllers\AdminPanel\CategoryController;
use App\Http\Controllers\AdminPanel\CourseController;
use App\Http\Controllers\AdminPanel\LectureController;
use App\Http\Controllers\AdminPanel\TeacherController;
use App\Http\Controllers\AdminPanel\QuestionController;
use App\Http\Controllers\AdminPanel\TermController;
use App\Http\Controllers\AdminPanel\ContactController;
use App\Http\Controllers\AdminPanel\LessonController;
use App\Http\Controllers\AdminPanel\CouponController;
use App\Http\Controllers\AdminPanel\OfferController;
use App\Http\Controllers\AdminPanel\PackageController;
use App\Http\Controllers\AdminPanel\IntroController;
use App\Http\Controllers\AdminPanel\BookController;
use App\Http\Controllers\AdminPanel\ExamController;
use App\Http\Controllers\AdminPanel\DirectClassController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::middleware(['guest'])->group(function () {
            Route::get('/', [AuthController::class, 'login'])->name('auth.login');
            Route::get('/login', [AuthController::class, 'postLogin'])->name('post.login');
        });

        Route::middleware('auth:web')->group(function () {
            Route::get('/dashboard', function () {
                return view('welcome');
            })->name('dashboard');

            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::resource('admins', AdminController::class);
            Route::resource('role', RoleController::class);
            Route::resource('permessions', PermessionController::class);
            Route::resource('settings', SettingController::class);
            Route::resource('categories',CategoryController::class);

            Route::resource('courses',CourseController::class);
            Route::get('/get-users-by-category/{categoryId}', [CourseController::class, 'getUsersByCategory'])
                            ->name('getUsersByCategory');

            Route::resource('lectures', LectureController::class );
            Route::resource('teachers', TeacherController::class );
            Route::resource('questions', QuestionController::class);
            Route::resource('terms', TermController::class);
            Route::resource('contacts', ContactController::class);
            Route::resource('lessons', LessonController::class);
            Route::get('/get-lessons/{course_id}', [LectureController::class, 'getLessons'])->name('get.lessons');
            Route::resource('coupons', CouponController::class );
            Route::resource('offers', OfferController::class );
            Route::resource('packages', PackageController::class);
            Route::resource('intros', IntroController::class);
            Route::resource('books', BookController::class);
            Route::resource('exams', ExamController::class);
            Route::get('/courses/{course}/lessons', [ExamController::class, 'getLessons']);
            Route::resource('direct-classes', DirectClassController::class );
        });
    }
);

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');



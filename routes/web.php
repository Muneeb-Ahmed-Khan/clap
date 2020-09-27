<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index');
Route::get('/index', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
Route::get('/copyright', 'PagesController@copyright');
Route::get('/dmca', 'PagesController@dmca');
Route::get('/faq', 'PagesController@faq');
Route::get('/register', 'PagesController@register');
Route::get('/terms', 'PagesController@terms');

Route::namespace('Auth')->group(function(){

    /* Reset Password Routes */
    //For checking out multi-Auth Password reset : https://ysk-override.com/Multi-Auth-in-laravel-54-Reset-Password-20170205/
    Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');




    /* Verification Routes */
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::get('email/resend/{role}/{email}', 'VerificationController@resend')->name('verification.resend');

    /*LOGIN / Regsiter  Routes */
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@LoginLogic');
    Route::post('/register', 'RegisterController@RegisterLogic');
    Route::get('/register', 'RegisterController@showRegisterForm');

    /*LOGOUT  Routes */
    Route::post('/logout','LoginController@logout');
});


Route::get('/unauthorized', function($request, $guard = null)
{
    if (Auth::guard('student')->check()) {
        return redirect('/student');
    }
    elseif (Auth::guard('teacher')->check()) {
        return redirect('/teacher');
    }
    elseif (Auth::guard('student')->check()) {
        return redirect('/principal');
    }
    else
    {
        return redirect('/');
    }
})->name('ReturnToUnauthorizedPage');


/*Only student can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:student','verified']], function () {

    Route::get('/student','StudentController@Dashboard');
    Route::get('/student/{courseId}', 'StudentController@ManageCourse');

    Route::get('/student/{courseId}/summary', 'StudentController@DetailedSummary');

    Route::get('/student/{courseId}/TakeTest', 'StudentController@TakeTest');

    Route::get('/student/{courseId}/chapter/{chapterId}/view', 'StudentController@Show_Chapter_Content');
    Route::get('/student/{courseId}/chapter/{chapterId}/viewRR', 'StudentController@Show_RR_Content');

    Route::post('/student/checkQuiz/{courseId}/{chapterId}', 'StudentController@CheckQuiz');

    Route::post('/student/{courseId}/submitTest', 'StudentController@CheckTest');

    Route::post('/student/{courseId}/{chapterId}/submitRR', 'StudentController@SubmitRR');

    #View the Quiz and Round Robin at Chapter
    Route::get('/student/{courseId}/{chapterId}/{recordId}/ViewRR', 'StudentController@ViewRR');
    Route::get('/student/{courseId}/progress/{studentId}/viewChapterDetails/{chapter_record_Id}', 'StudentController@StudentViewQuiz');

});

/*Only teacher can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:teacher','verified']], function () {

    Route::get('/teacher', 'TeachersController@Dashboard');
    Route::get('/teacher/{courseId}', 'TeachersController@ManageCourse');

    #DELETE CHAPTER
    Route::post('/teacher/DeleteChapter', 'TeachersController@DeleteChapter')->name('DeleteChapter');

    Route::get('/teacher/{courseId}/summary', 'TeachersController@CourseSummary');

    Route::get('/teacher/{courseId}/chapter/new', 'TeachersController@NewChapter');
    Route::post('/teacher/{courseId}/chapter/new', 'TeachersController@ManageNewChapter')->name('ManageNewChapter');


    Route::get('/teacher/{courseId}/createtest', 'TeachersController@CreateTest');
    Route::post('/teacher/{courseId}/createtest', 'TeachersController@ManageCreatedTest')->name('SaveTest');


    Route::post('/teacher/{courseId}/startTest', 'TeachersController@StartTest')->name('StartTest');;

    Route::post('/teacher/{courseId}/ManageBroadcast', 'TeachersController@ManageBroadcast')->name('ManageBroadcast');

    Route::get('/teacher/{courseId}/chapter/{chapterId}/ViewAsStudent', 'TeachersController@ViewAsStudent');
    Route::get('/teacher/{courseId}/chapter/{chapterId}/listRR', 'TeachersController@ListRR');
    Route::get('/teacher/{courseId}/chapter/{chapterId}/summary', 'TeachersController@ChapterSummary');
    Route::get('/teacher/{courseId}/{chapterId}/{recordId}/ViewRR', 'TeachersController@ViewRR');


    Route::post('/teacher/checkAnswer/{chapterName}', 'TeachersController@CheckQuiz');

    Route::post('/teacher/{courseId}/stopTest', 'TeachersController@stopTest');
    
    Route::get('/teacher/{courseId}/viewTest', 'TeachersController@viewTest');
    #Route::get('/teacher/{courseId}/viewTests', 'TeachersController@ShowAllSharedTests');
    

    Route::get('/teacher/{courseId}/progress', 'TeachersController@StudentProgress');
    Route::get('/teacher/{courseId}/progress/{studentId}', 'TeachersController@ShowFullProgress');
    #Evaluate the Test
    Route::get('/teacher/{courseId}/progress/{studentId}/evaluate/{test_record_Id}', 'TeachersController@StudentEvaluation');
    #View the Quiz at Chapter
    Route::get('/teacher/{courseId}/progress/{studentId}/viewChapterDetails/{chapter_record_Id}', 'TeachersController@StudentViewQuiz');

    Route::post('/teacher/{courseId}/progress/{studentId}/changemarks', 'TeachersController@AssignMarks');

    

});



/*Only principal can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:principal','verified']], function () {

    Route::get('/principal', 'PrincipalController@Dashboard');
    Route::post('/principal','PrincipalController@ManageSchool')->name('ManageSchool');

    Route::get('/principal/{schoolId}', 'PrincipalController@SchoolView');
    Route::post('/principal/{schoolId}', 'PrincipalController@ManageUpload')->name('ManageUpload');

    Route::get('/principal/{schoolId}/courses/{courseId}', 'PrincipalController@ManageSubjects')->name('ManageSubjects');
});


//used to delete the cache stored when redirect with data from some function.
header('Cache-Control: no-store, private, no-cache, must-revalidate'); header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Expires: 0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header ('Pragma: no-cache');

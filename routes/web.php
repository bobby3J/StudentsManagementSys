<?php
use App\Http\Middleware\Bouncer;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Mail\WelcomeMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

Route::get('/mail', function(){
    Mail::to('$email')->send(new WelcomeMessage());
});


// Route::get('/students',[StudentController::class, 'index'])->name('students.index');

// Route::get('/students/create',[StudentController::class, 'create'])->name('students.create');

// Route::get('/students/{id}',[StudentController::class, 'show'])->name('students.show');

// Route::post('/students',[StudentController::class, 'store'])->name('students.store');

// Route::get('/students/{id}/edit',[StudentController::class, 'edit'])->name('students.edit');

// Route::patch('/students/{id}',[StudentController::class, 'update'])->name('students.update');

// Route::delete('/students/{id}',[StudentController::class, 'destroy'])->name('students.destroy');


// Route::get('/login', [AuthController::class,'getLoginPage'])->name('auth.loginPage');

Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'getLoginPage'])->name('login')->middleware('guest');




Route::get('/forgot-password',[AuthController::class, 'getForgotPasswordPage'])->name('auth.getForgotPasswordPage')->middleware('guest');
Route::post('/forgot-password',[AuthController::class, 'requestForgotPasswordLink'])->name('auth.requestForgotPasswordLink')->middleware('guest');

Route::get('/reset-password/{token}',[AuthController::class, 'getPasswordResetPage'])->name('password.reset')->middleware('guest');
Route::post('/reset-password',[AuthController::class, 'resetPassword'])->name('auth.resetPassword')->middleware('guest');



Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');


// Route::middleware(['auth'])->group(function () {
//    // Routes accessible to both admins and superadmins
//    Route::resource('students', StudentController::class);
//    Route::resource('courses', CourseController::class);
//    Route::resource('subjects', SubjectController::class);

//    // Route accessible only to superadmins
//    Route::middleware(['checkUserRole:superadmin'])->group(function () {
//        Route::resource('users', UserController::class);
//    });
// });

Route::middleware(['auth'])->group(function () {
   // Routes accessible to both admins and superadmins
   Route::resource('students', StudentController::class);
   Route::resource('courses', CourseController::class);
   Route::resource('subjects', SubjectController::class);

  // Route accessible only to superadmins
   Route::group(['middleware' => function ($request, $next) {
       if (Auth::check() && Auth::user()->role === 'superadmin') {
           return $next($request);
       }
       return redirect()->route('homepage')->with('error', 'Access denied.');
   }], function () {
       Route::resource('users', UserController::class);
   });
 });


// Route::resource('students', StudentController::class)->middleware('auth');
// Route::resource('courses', CourseController::class)->middleware('auth');
// Route::resource('subjects', SubjectController::class)->middleware('auth');
// Route::resource('users', UserController::class)->middleware('Bouncer');




// Parsing data to the view
// Route::get('/homepage/{name}', function(){
//     // the key should be the variable name the view is expecting 'key'=>'value'
//     return view('homepage', [
//         'name'=>'Bobs'
//     ]);
// });


Route::get('/homepage', function(){
   $name = request()->query('name');
   $age = request()->query('age');
   $number = request()->query('number', 1);
   return view('homepage', [
      'name'=> $name,
      'age'=> $age,
      'number'=> $number
   ]);
})->name('homepage'); //->middleware('auth');

// Route::get('/login', [AuthController::class, 'getLoginPage'])->name('auth.login');

// Route::get("/students/{id}/{name}", function(string $id, $name){
//     // return route('hello');

   
//     return "<h1> Id: {$id} Student: {$name} </h1>";
// });
// Route::get('/multiplication-table', [YourController::class, 'showMultiplicationTable']);


// public function showMultiplicationTable(Request $request)
// {
//     $number = $request->query('number', 1); // Default to 1 if no number is provided
//     return view('multiplication_table', compact('number'));
// }



































// Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');

// Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');

// Route::post('/students', [StudentController::class, 'store'])->name('students.store');

// Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');

// Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');


// // Route::get('/students/create', [StudentController::class, 'edit'])->name('students.edit');
// Route::get('/students/{id}/edit', [StudentController::class,'edit'])->name('students.edit');






















// Route::get('/hello', [StudentController::class, 'sayHello']);

// Route::get("/hi", [StudentController::class, 'sayHi']);

// Route::get('/students', [StudentController::class, 'studentDetails']);


























// Route::get('/', function () {
//     return view('welcome');
// })->name('hello'); //name of the route handler;

// Route::get('/hello', function(){
//     return "Hi";
// });

// Route::get("/students", function(){
//     return "<h1>Student: Abi</h1>";
// })->middleware(Bouncer::class);



// use App\Http\Middleware\Bouncer;?

// Route::get('/your-route', function () {
//     return 'Welcome!';
// })->middleware(Bouncer::class);

// Route::get('/your-route', 'YourController@method')->middleware('bouncer');


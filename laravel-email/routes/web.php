<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\ApplicationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-mail', [SendEmailController::class,
'index'])->name('kirim-email');

Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/job',[JobController::class,'index']);

Route::get('/admin', function () {
    return view('admin.admin');
})->middleware('auth','isadmin');

Route::get('/admin/jobs', [JobController::class, 'index'])
    ->name('admin.jobs')
    ->middleware('auth','isadmin');

Route::post('/jobs/{job}/apply', 
    [ApplicationController::class, 'store']
)->name('apply.store')
 ->middleware('auth');

Route::get('/jobs/{job}/applicants', 
    [ApplicationController::class, 'index']
)->name('applications.index')
 ->middleware('isAdmin');

Route::post('/jobs/{job}/apply', 
    [ApplicationController::class, 'store']
)->name('apply.store')
 ->middleware('auth');

Route::get('/jobs/{job}/applicants', 
    [ApplicationController::class, 'index']
)->name('applications.index')
 ->middleware('isAdmin');

Route::middleware('auth')->group(function () {
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
        ->name('apply.store');
});

Route::middleware('isAdmin')->group(function () {
    Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
        ->name('applications.index');
});

// routes/web.php

// Routes untuk jobs
Route::resource('jobs', JobController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('jobs', JobController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);


// Routes untuk applications
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('applications', ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);


Route::get('/applications/export', 
[ApplicationController::class, 'export'])->name('applications.export')->middleware('isAdmin');

Route::get('/jobs/{job}/applications/export', 
[ApplicationController::class, 'exportByJob'])->name('jobs.applications.export')->middleware('isAdmin');

Route::get('/applications/{application}/download', 
[ApplicationController::class, 'download'])->name('applications.download')->middleware('isAdmin');

Route::post('jobs/import', 
[JobController::class,'import'])->name('jobs.import')->middleware('isAdmin');

Route::get('jobs/template/download', 
[JobController::class,'downloadTemplate'])->name('jobs.template.download')->middleware('isAdmin');

Route::patch('/applications/{application}/status', 
[ApplicationController::class, 'updateStatus'])->name('applications.updateStatus')->middleware('isAdmin');

require __DIR__.'/auth.php';

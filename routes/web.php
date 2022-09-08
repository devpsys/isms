<?php

use App\Http\Controllers\KlassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimingController;
use App\TTAlgo\Data;
use App\TTAlgo\Population;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {

    $data = new Data();
    $generationNumber = 0;
//    print "\n> Generation #$generationNumber";
    $population_size = 1;
    $population = new Population($population_size, $data);
    echo(json_encode($population->getSchedules()));
});

Route::prefix('manage')->group(function () {

    //  Sessions
    Route::prefix('sessions')->group(function () {
        Route::get('/', [SessionController::class, 'index'])->name('manage.sessions');
        Route::post('/store', [SessionController::class, 'store'])->name('manage.sessions.store');
        Route::post('/destroy', [SessionController::class, 'destroy'])->name('manage.sessions.destroy');
    });

    //  Sections
    Route::prefix('sections')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('manage.sections');
        Route::post('/store', [SectionController::class, 'store'])->name('manage.sections.store');
        Route::post('/destroy', [SectionController::class, 'destroy'])->name('manage.sections.destroy');
    });

    //  Classes
    Route::prefix('classes')->group(function () {
        Route::get('/', [KlassController::class, 'index'])->name('manage.classes');
        Route::post('/store', [KlassController::class, 'store'])->name('manage.classes.store');
        Route::post('/destroy', [KlassController::class, 'destroy'])->name('manage.classes.destroy');
    });

    //  Subjects
    Route::prefix('subjects')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('manage.subjects');
        Route::post('/store', [SubjectController::class, 'store'])->name('manage.subjects.store');
        Route::post('/destroy', [SubjectController::class, 'destroy'])->name('manage.subjects.destroy');
    });

    //  Teachers
    Route::prefix('teachers')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('manage.teachers');
        Route::post('/store', [TeacherController::class, 'store'])->name('manage.teachers.store');
        Route::post('/assign', [TeacherController::class, 'assign'])->name('manage.teachers.assign');
        Route::post('/destroy', [TeacherController::class, 'destroy'])->name('manage.teachers.destroy');
        Route::get('/teacher/subjects/{teacher}', [TeacherController::class, 'subjects'])->name('manage.teachers.teacher.subjects');
    });

    //  Timings
    Route::prefix('timings')->group(function () {
        Route::get('/', [TimingController::class, 'index'])->name('manage.timings');
        Route::post('/store', [TimingController::class, 'store'])->name('manage.timings.store');
        Route::post('/destroy', [TimingController::class, 'destroy'])->name('manage.timings.destroy');
    });
});

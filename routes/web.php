<?php

use App\Http\Controllers\SectionController;
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

    //  Sections
    Route::prefix('sections')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('manage.sections');
        Route::post('/store', [SectionController::class, 'store'])->name('manage.sections.store');
        Route::post('/destroy', [SectionController::class, 'destroy'])->name('manage.sections.destroy');
    });

    //  Classes
    Route::prefix('classes')->group(function () {
        Route::get('/', function () {
            echo 'Classes!';
        });
    });

    //  Subjects
    Route::prefix('subjects')->group(function () {
        Route::get('/', function () {
            echo 'Subjects!';
        });
    });

    //  Teachers
    Route::prefix('teachers')->group(function () {
        Route::get('/', function () {
            echo 'Teachers!';
        });
    });
});

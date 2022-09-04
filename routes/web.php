<?php

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
    $population =  new Population($population_size,$data);
    echo (json_encode($population->getSchedules())) ;


});

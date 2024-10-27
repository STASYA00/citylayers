<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\SocialiteController;
use App\Http\Middleware\Cors;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectImageController;
use App\Http\Controllers\PartnerController;
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

Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);



Route::controller(GlobalController::class)->group(function () {
    // Route::get('/', 'getAll')->name('getAll')->middleware('App\Http\Middleware\MyMiddleware');
    // Route::get('/', 'homeDefault')->name('default');
    Route::get('edit/{id}', 'getAll');

    // Route::get('/get-started', 'getAll');

    Route::get('/', 'getAll')->name('default');

    Route::get('grade', 'grade')->name('grade');
    
    
    Route::get('impressum', function () {
        return view('impressum');
    });
    Route::get('privacy', function () {
        return view('privacy');
    });
    Route::get('accessibility', function () {
        return view('accessibility');
    });
    Route::get('team', function () {
        return view('team');
    });

    Route::get('approach', function () {
        return view('impressum');
    });

    Route::get('awards', function () {
        return view('impressum');
    });

    Route::get('atresponsivecities', function () {
        return view('impressum');
    });

    Route::get('testapi', function () {
        return view('test');
    });
    Route::get('createconfig', function () {
        return view('createConfig');
    });
    Route::get('addPartner', function () {
        return view('addPartner');
    });

});

Route::get('explore', function () {
    return view('home')->with('project_id', "");
});

Route::get('explore/{project_id}', function (string $project_id) {
    
    return view('projectMap')->with('project_id', $project_id);;
});

Route::get('project/{project_id}', function (string $project_id) {
    
    return view('projectCard')->with('project_id', $project_id);;
});

Route::get('pin/{project_name}', function (string $project_name) {
    
    return view('addPin')->with('project_name', $project_name);;
});

Route::get('landing', function () {
    return view('landing');
});

Route::get('contact', function () {
    return view('contact');
});


Route::get('categories', [CategoryController::class, 'all']);
Route::get('configs', [ConfigController::class, 'all']);
Route::get('configcategories/{config_id?}', [ConfigController::class, 'categories']);
Route::get('questions', [GlobalController::class, 'questions']);
Route::get('pages', [GlobalController::class, 'pages']);
Route::get('places', [GlobalController::class, 'places']);
Route::get('comments', [GlobalController::class, 'comments']);
Route::get('partners', [PartnerController::class, 'all']);
Route::get('projectimages', [ProjectImageController::class, 'all']);

// Route::get('category/{category_id?}', [GlobalController::class, 'categories'])->array_filter();

Route::get('subcategories', [GlobalController::class, 'subcategories']);
Route::get('subcategories/{category_id?}', [GlobalController::class, 'subcategories'])->where('category_id', 'category_id');
Route::get('subcategory/{subcategory_id?}', [GlobalController::class, 'subcategories'])->where('subcategory_id', 'subcategory_id');

Route::get('add-pin', function () {
    return view('addPin', [1]);});
// Route::get('pin', function () {return view('addPin');});
Route::get('add-pin/post-success', function () {return view('postSuccess');});
Route::get('add-pin/post-error', function () {return view('postError');});

//<-------------------------new routes---------------------------------------->



Route::get('filter', [GlobalController::class, 'filter']);
Route::get('truncate', [GlobalController::class, 'truncate']);

Route::post('/save-all', [GlobalController::class, 'saveObs']);
Route::post('/save-comment', [GlobalController::class, 'saveComment']);
Route::post('/save-grade', [GlobalController::class, 'saveGrade']);
Route::post('/save-image', [GlobalController::class, 'saveImage']);
Route::post('/save-place', [GlobalController::class, 'savePlace']);
Route::post('/save-subgrade', [GlobalController::class, 'saveSubgrade']);
Route::post('/save-subgrades', [GlobalController::class, 'saveSubgrades']);

Route::post('/save-category', [CategoryController::class, 'save']);
Route::post('/save-partner', [PartnerController::class, 'save']);
Route::post('/save-config', [ConfigController::class, 'save']);
Route::post('/assign-config', [ConfigController::class, 'assign']);
Route::post('/assignsubcat-config', [ConfigController::class, 'assign_subcategories']);
Route::post('/save-project', [ProjectController::class, 'save']);
Route::post('/add-project-partner', [ProjectController::class, 'addPartner']);
Route::post('/add-project-image', [ProjectController::class, 'AddImage']);
Route::post('/add-project-person', [ProjectController::class, 'addPerson']);




if (env('FORCE_HTTPS')) {
    URL::forceScheme('https');
} else {
    URL::forceScheme('http');
}

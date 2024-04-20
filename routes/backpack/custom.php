<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\MyMiddleware;


// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('pages', 'PagesCrudController');

    Route::crud('place', 'StreetCrudController');
    Route::crud('openspace', 'OpenspaceCrudController');
    Route::crud('building', 'BuildingCrudController');
 
    Route::crud('tag', 'TagCrudController');

    Route::crud('stat', 'StatCrudController');
    Route::crud('opinion', 'OpinionCrudController');
    
    Route::crud('space-tag', 'SpaceTagCrudController');
    Route::crud('space-tag-de', 'SpaceTagDeCrudController');
    Route::crud('opinion-de', 'OpinionDeCrudController');
    Route::crud('tag-de', 'TagDeCrudController');
    Route::crud('comment-de', 'CommentDeCrudController');
    Route::crud('comment-en', 'CommentsEnCrudController');
    Route::crud('grades-test', 'GradeCrudController');
    Route::crud('subgrades-test', 'SubgradeCrudController');
}); // this should be the absolute last line of this file
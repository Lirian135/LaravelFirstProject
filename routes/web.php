<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); 
});

//Different return types

Route::get('/courses', function(){
    return "<h1>Available Courses</h1>";
});

Route::get('/home', function(){
    $url = route('courses');

    return "<h1>Welcome to Home Page</h1><br><a href='$url'>Courses</a>";
});

Route::get('/courses/{id}', function($id){
    return "<h1>Course: $id</h1>";
})->where('id', '[0-9]+');

Route::get('/courses/{id}/{title}', function($id, $title){
    return "<h1>Course $id: $title</h1>";
})->whereNumber('id')->whereAlpha('title');

Route::get('/courses/category/{category?}', function($category = null){
    return $category ? "<h1>Category: $category</h1>" : "<h1>Available Courses</h1>";
})->whereAlpha('category');

Route::get('/courses/search', function (Request $request) {
    return response()->json([
        'keyword' => $request->query('keyword'),
        'level' => $request->input('level', 'Beginner'),
        'hasKeyword' => $request->has('keyword'),
    ]);
});


Route::get('/courses/featured', function () {
    return response()->json([
        "message"=> "Featured Courses",
            
        ],200)->header('X-Course-Source', 'Laravel')->cookie('last-visited', 'featured');
})->name('courses');

Route::get('/catalog', function () {
    return redirect()->route('courses');
});
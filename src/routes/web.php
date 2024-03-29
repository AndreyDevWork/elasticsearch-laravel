<?php

use App\Models\Article;
use Illuminate\Support\Facades\Route;

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

Route::get("/", function () {
    $article = new Article([
        "title" => "Заголовок статьи",
        "body" => "Текст статьи",
    ]);

    // Сохраняем статью в базе данных
    $article->save();
    return view("welcome");
});

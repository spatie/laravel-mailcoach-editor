<?php

use Spatie\MailcoachEditor\Http\Controllers\EditorController;

Route::post('render', [EditorController::class, 'render']);
Route::post('upload', [EditorController::class, 'upload']);


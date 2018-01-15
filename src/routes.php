<?php

namespace App;

use App\Controllers\ClubController;
use App\Controllers\EventController;
use App\Controllers\ResultController;
use App\Controllers\ShooterController;

/**
 * Shooter
 */
$app->get('/shooter/{id}', ShooterController::class . ':get');
$app->post('/shooter', ShooterController::class . ':post');
$app->put('/shooter/{id}', ShooterController::class . ':put');
$app->delete('/shooter/{id}', ShooterController::class . ':delete');

/**
 * Club
 */
$app->get('/club/{id}', ClubController::class . ':get');
$app->post('/club', ClubController::class . ':post');
$app->put('/club/{id}', ClubController::class . ':put');
$app->delete('/club/{id}', ClubController::class . ':delete');

/**
 * Event
 */
$app->get('/event/{id}', EventController::class . ':get');
$app->post('/event', EventController::class . ':post');
$app->put('/event/{id}', EventController::class . ':put');
$app->delete('/event/{id}', EventController::class . ':delete');

/**
 * Result
 */
$app->get('/result/{id}', ResultController::class . ':get');
$app->post('/result', ResultController::class . ':post');
$app->put('/result/{id}', ResultController::class . ':put');
$app->delete('/result/{id}', ResultController::class . ':delete');
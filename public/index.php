<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

use App\Controllers\UsersController;
use App\Controllers\AuthController;
use App\Controllers\LoginController;
use App\Controllers\PesertaController;
use App\Controllers\ProfileController;
use App\Controllers\RegController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

// Router::add('POST', '/login', AuthController::class, 'login');
// Router::add('GET', '/users', UsersController::class, 'index', [
//     AuthMiddleware::class,
//     AdminMiddleware::class
// ]);
// Router::add('GET', '/users/{id}', UsersController::class, 'show');


Router::add('POST','/users/{data}', UsersController::class,'create');

Router::add('POST', '/login', LoginController::class, 'login');
Router::add('GET', '/check', LoginController::class, 'check');
Router::add('PUT', '/lupapass/{nama}', LoginController::class, 'lupaPassword');
Router::add('DELETE', '/logout', LoginController::class, 'logout');

Router::add('PUT', '/lupass/{id}', LoginController::class, 'reset',
[
    AuthMiddleware::class,
    AdminMiddleware::class
]);

Router::add('GET', '/regs',RegController::class,'index');
Router::add('GET', '/regs/{id}',RegController::class,'show');
Router::add('POST','/regs/{data}',RegController::class,'create');
Router::add('PUT', '/regs/{id}',RegController::class,'update',
[
    AuthMiddleware::class,
    AdminMiddleware::class
]);

Router::add('GET', '/peserta',PesertaController::class,'index');
Router::add('GET', '/peserta/{id}',PesertaController::class,'show');
Router::add('POST','/peserta/{data}',PesertaController::class,'create');

Router::add('GET', '/profile/{id}',ProfileController::class,'profile');
Router::add('GET', '/profile',ProfileController::class,'index');


Router::run();


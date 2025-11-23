<?php

require_once __DIR__.'/../src/Support/Api.php';
require_once __DIR__.'/../src/Actions/DestroyTodoAction.php';
require_once __DIR__.'/../src/Actions/UpdateTodoAction.php';
require_once __DIR__.'/../src/Actions/StoreTodoAction.php';
require_once __DIR__.'/../src/Actions/ListTodoAction.php';

use App\Actions\DestroyTodoAction;
use App\Actions\ListTodoAction;
use App\Actions\StoreTodoAction;
use App\Actions\UpdateTodoAction;
use App\Support\Api;

Api::capture(
    function ($router) {
        $router->get(ListTodoAction::class);
        $router->post(StoreTodoAction::class);
        $router->patch(UpdateTodoAction::class);
        $router->delete(DestroyTodoAction::class);
    }
);

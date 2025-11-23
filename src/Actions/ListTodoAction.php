<?php

namespace App\Actions;

require_once __DIR__.'/../Models/Todo.php';

use App\Models\Todo;

class ListTodoAction
{
    public function __invoke(array $data)
    {
        $result = $this->handle();

        if (is_null($result)) {
            http_response_code(403);

            return json_encode(['success' => false]);
        }

        http_response_code(200);

        return json_encode(['success' => true, 'data' => $result]);
    }

    public function handle()
    {
        return (new Todo)->all();
    }
}

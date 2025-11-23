<?php

namespace App\Actions;

require_once __DIR__.'/../Models/Todo.php';

use App\Models\Todo;

class StoreTodoAction
{
    public function __invoke(array $data)
    {
        $taskName = $data['task_name'] ?? null;

        $stored = $this->handle($taskName);

        if (! $stored) {
            http_response_code(403);

            return json_encode(['success' => false]);
        }

        http_response_code(200);

        return json_encode(['success' => true]);
    }

    public function handle(string $name)
    {
        return (new Todo)->create(['task_name' => $name]);
    }
}

<?php

namespace App\Actions;

require_once __DIR__.'/../Models/Todo.php';

use App\Models\Todo;

class DestroyTodoAction
{
    public function __invoke(array $data)
    {
        $deleted = $this->handle($data['id'] ?? null);

        if (! $deleted) {
            http_response_code(403);

            return json_encode(['success' => false]);
        }

        http_response_code(200);

        return json_encode(['success' => true]);
    }

    public function handle(string $id)
    {
        return (new Todo)->delete($id);
    }
}

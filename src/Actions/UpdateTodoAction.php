<?php

namespace App\Actions;

require_once __DIR__.'/../Models/Todo.php';

use App\Models\Todo;

class UpdateTodoAction
{
    public function __invoke(array $data)
    {
        $updated = $this->handle($data['id'] ?? null, $data);

        if (! $updated) {
            http_response_code(403);

            return json_encode(['success' => false]);
        }

        http_response_code(200);

        return json_encode(['success' => true]);
    }

    public function handle(string $id, array $data = [])
    {
        return (new Todo)->update($id, $data);
    }
}

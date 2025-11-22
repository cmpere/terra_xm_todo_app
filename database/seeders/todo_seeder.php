<?php

use Models\Todo;

require_once __DIR__.'/../../src/Support/DB.php';
require_once __DIR__.'/../../src/Models/Todo.php';

return new class
{
    public function run()
    {
        foreach (range(1, 10) as $task) {
            (new Todo)->create(['task_name' => "Tarea de ejemplo {$task}"]);
        }
    }
};

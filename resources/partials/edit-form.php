<?php

require_once __DIR__.'/../../src/Models/Todo.php';

use App\Models\Todo;

$todo = (new Todo)->find($_GET['id'] ?? null);
?>

<script>state.upsert.data = <?php echo json_encode($todo ?? []) ?></script>

<div class="border-b border-slate-300 p-4 flex items-center h-24">
    <input
        autofocus
        type="text"
        id="task_name"
        name="task_name"
        value="<?php echo $todo['task_name'] ?>"
        class="w-full text-lg outline-none px-2 py-4"
        placeholder="<?php echo $todo['task_name'] ?>" />
    
    <button class="btn save hover:bg-terra/70 bg-terra cursor-pointer rounded-lg p-4">
        <div class="flex items-center justify-center gap-4">
            <i data-lucide="save" class="text-slate-900"></i>
        </div>
    </button>
</div>
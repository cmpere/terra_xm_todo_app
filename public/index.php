<?php

require_once __DIR__.'/../src/Models/Todo.php';
require_once __DIR__.'/../src/helpers.php';

?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__.'/../resources/partials/head.php'; ?>

<body class="bg-slate-50 flex flex-col items-center justify-center p-4">    

    <img class="h-16 my-8" src="https://www.terraenergy.mx/images/terra-logo.svg" alt="">

    <div class="w-full lg:max-w-lg">
        <div class="grid px-0 shadow-xl rounded-lg bg-white overflow-hidden">
            <!-- Feedback -->
            <div class="p-4 text-white bg-terra text-sm success truncate hidden"></div>
            <div class="p-4 text-white bg-rose-600/50 text-sm error truncate hidden"></div>

            <!-- Add form -->
            <?php include __DIR__.'/../resources/partials/add.php'; ?>

            <!-- Todo list -->           
            <div class="max-h-[55vh] overflow-y-scroll" id="todo-list">
                <div class="p-4 flex item-center justify-center">
                    <i data-lucide="loader-circle" class="text-slate-900 animate-spin"></i>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__.'/../resources/partials/bottom.php'; ?>
</body>

</html>
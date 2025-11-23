<?php

require_once __DIR__.'/../src/Models/Todo.php';
require_once __DIR__.'/../src/helpers.php'; ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include __DIR__.'/../resources/partials/head.php'; ?>
        <script src="/dist/app.js"></script>
    </head>
    <body class="bg-slate-50 flex flex-col items-center justify-center p-4">
        <?php include __DIR__.'/../resources/partials/brand.php'; ?>
        <div class="w-full lg:max-w-lg">
            <div class="grid px-0 shadow-xl rounded-lg bg-white overflow-hidden">
                <?php include __DIR__.'/../resources/partials/messages.php'; ?>           
                <?php include __DIR__.'/../resources/partials/add.php'; ?>                
                <?php include __DIR__.'/../resources/partials/list.php'; ?>                            
            </div>
        </div>
        <div id="destroy-confirm" title="¿Deseas continuar?">
            <p>Eliminar la tarea: <span id="destroy-confirm-message" class="font-bold"></span></p>   
        </div>
        <?php include __DIR__.'/../resources/partials/bottom.php'; ?>
    </body>
</html>
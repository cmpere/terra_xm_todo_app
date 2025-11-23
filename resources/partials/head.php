<?php

require_once __DIR__.'/../../src/Support/Config.php';

use App\Support\Config;

?>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title><?php echo Config::get()['APP']['NAME'] ?></title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<style type="text/tailwindcss">
    @theme { --color-terra: #7cb342; }
</style>

<script src="/dist/services.js"></script>
<script src="/dist/helpers.js"></script>


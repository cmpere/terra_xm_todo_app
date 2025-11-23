<?php

namespace App\Models;

require_once __DIR__.'/../Support/Model.php';

use App\Support\Model;

class Todo extends Model
{
    protected $table = 'todos';
}

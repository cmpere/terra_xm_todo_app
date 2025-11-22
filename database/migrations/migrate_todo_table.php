<?php

require_once __DIR__.'/../../src/Support/DB.php';

use App\Support\DB;

return new class
{
    public function up()
    {
        $pdo = DB::getInstance()?->getConnection();

        $sql = '
        CREATE TABLE IF NOT EXISTS todos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            task_name VARCHAR(255) NOT NULL,            
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ';

        $pdo->exec($sql);
    }

    public function down()
    {
        $pdo = DB::getInstance()?->getConnection();

        $sql = 'DROP TABLE IF EXISTS todos;';

        $pdo->exec($sql);
    }
};

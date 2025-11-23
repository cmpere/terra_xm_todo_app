<?php

namespace App\Support;

require_once __DIR__ . '/Config.php';

use PDO;
use Throwable;

class DB
{
    private static $instance = null;

    private $pdo = null;

    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static()->make();
        }

        return self::$instance;
    }

    public function make()
    {
        $config = $this->getConfig();

        $user = $config['DB']['USER'] ?? null;
        $host = $config['DB']['HOST'] ?? null;
        $port = $config['DB']['PORT'] ?? null;
        $password = $config['DB']['PASSWORD'] ?? null;

        try {
            $dsn = sprintf(
                "mysql:host=%s;port=%s;charset=utf8mb4",
                $host,
                $port
            );

            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (Throwable $th) {
            die('Database connection error: ' . $th->getMessage());
        }

        return $this;
    }

    public function connect(): self
    {
        $db = static::getInstance()->getDatabaseName();
        $pdo = static::getInstance()->getConnection();
        
        $pdo->exec("USE `{$db}`");

        return $this;
    }

    public static function migrate()
    {
        $pdo = static::getInstance()->getConnection();
        $db = static::getInstance()->getDatabaseName();

        if (!static::getInstance()->hasDatabase()) {
            echo "Creando la base de datos\n";
            $pdo->exec(
                "CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
            );
        }

        $hasTables = static::getInstance()->hasTables();

        if ($hasTables) {
            echo "Ya existen tablas en la base, ejecuta rollback para revertirlas (destructivo).\n";

            return;
        }

        echo "Migrando la base de datos...\n";

        $hasMigrations = static::getInstance()->hasMigrations();

        if (!$hasMigrations) {
            echo "No hay migraciones\n";
            return;
        }

        $migrations = static::getInstance()->getMigrations();
        $migrationDir = static::getInstance()->getMigrationDir();

        foreach ($migrations as $file) {
            $path = $migrationDir . '/' . $file;

            if (is_file($path)) {
                $migration = require $path;
                $migration->up();

                echo "Migrado: {$file}\n";
            }
        }
    }

    public static function seed()
    {
        $pdo = static::getInstance()->getConnection();
        $db = static::getInstance()->getDatabaseName();

        if (!static::getInstance()->hasDatabase()) {
            echo "Creando la base de datos\n";
            $pdo->exec(
                "CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
            );
        }

        $hasTables = static::getInstance()->hasTables();

        if (!$hasTables) {
            echo "No se ha migrado la base de datos.\n";

            return;
        }

        $hasSeeders = static::getInstance()->hasSeeders();

        if (!$hasSeeders) {
            echo "No hay seeders\n";
            return;
        }

        $seeders = static::getInstance()->getSeeders();
        $seedersDir = static::getInstance()->getSeedersDir();

        foreach ($seeders as $file) {
            $path = $seedersDir . '/' . $file;

            if (is_file($path)) {
                $seeder = require $path;
                $seeder->run();

                echo "Seeder ejecutado: {$file}\n";
            }
        }
    }

    public static function rollback()
    {
        $hasDatabase = static::getInstance()->hasDatabase();

        if (!$hasDatabase) {
            echo "La base de datos no existe\n";
            return;
        }

        $hasTables = static::getInstance()->hasTables();

        if (!$hasTables) {
            echo "No hay tablas en la base de datos\n";
            return;
        }

        $hasMigrations = static::getInstance()->hasMigrations();

        if (!$hasMigrations) {
            echo "No hay migraciones para revertir\n";
            return;
        }

        $migrations = static::getInstance()->getMigrations();
        $migrationDir = static::getInstance()->getMigrationDir();

        foreach ($migrations as $file) {
            $path = $migrationDir . '/' . $file;

            if (is_file($path)) {
                $migration = require $path;
                $migration->down();

                echo "Revertido: {$file}\n";
            }
        }
    }

    public function getConnection()
    {

        return $this->pdo;
    }

    public function getConfig(): array
    {
        return Config::get();
    }

    public function getMigrations()
    {
        $migrationsPath = static::getInstance()->getMigrationDir();

        return array_values(
            array_diff(scandir($migrationsPath), ['.', '..'])
        );
    }

    public function getSeeders()
    {
        $seedersPath = static::getInstance()->getSeedersDir();

        return array_values(
            array_diff(scandir($seedersPath), ['.', '..'])
        );
    }

    public function hasMigrations()
    {
        return count(static::getInstance()->getMigrations()) > 0;
    }

    public function getMigrationDir()
    {
        return __DIR__ . '/../../database/migrations';
    }

    public function hasSeeders()
    {
        return count(static::getInstance()->getSeeders()) > 0;
    }

    public function getSeedersDir()
    {
        return __DIR__ . '/../../database/seeders';
    }

    public function hasDatabase()
    {
        $config = static::getInstance()->getConfig();
        $pdo = static::getInstance()->getConnection();

        $db = $config['DB']['NAME'] ?? null;
        $stmt = $pdo->query("SHOW DATABASES LIKE '{$db}'");

        return count($stmt->fetchAll()) === 1;
    }

    public function hasTables()
    {
        $db = static::getInstance()->getDatabaseName();
        $pdo = static::getInstance()->getConnection();

        $pdo->exec("USE `{$db}`");
        $stmt = $pdo->query("SHOW TABLES");

        $result = $stmt->fetchAll();

        return count($result) > 0;
    }

    public function getDatabaseName()
    {
        return static::getInstance()->getConfig()['DB']['NAME'] ?? null;
    }
}

<?php

namespace App\Support;

require_once __DIR__.'/DB.php';

class Model
{
    protected $table;

    protected $pdo;

    public function __construct()
    {
        $this->pdo = DB::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = array_fill(0, count($data), '?');
        $values = implode(',', $placeholders);
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");

        $stmt->execute(array_values($data));

        return $this;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");

        return $stmt->fetchAll();
    }

    public function find($id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function update(string $id, array $data): bool
    {
        $placeholders = array_map(fn ($key) => "$key = ?", array_keys($data));
        $set = implode(',', $placeholders);
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = ?");

        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");

        return $stmt->execute([$id]);
    }
}

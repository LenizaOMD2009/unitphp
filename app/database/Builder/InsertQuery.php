<?php

declare(strict_types=1);

namespace App\Database\Builder;

use app\database\Connection;

class InsertQuery
{
    private string $table;
    private array $FieldsAndValues = [];

    /**
     * Alias estático para InsertQuery::insert('tabela')->save([...])
     */
    public static function insert(string $table): self
    {
        return self::table($table);
    }

    /**
     * Define a tabela onde os dados serão inseridos.
     */
    public static function table(string $table): self
    {
        $self        = new self;
        $self->table = $table;
        return $self;
    }

    private function createQuery(): string
    {
        $fields      = implode(',', array_keys($this->FieldsAndValues));
        $placeHolder = ':' . implode(',:', array_keys($this->FieldsAndValues));
        return "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeHolder});";
    }

    private function execute(string $query): bool
    {
        $con     = Connection::connection();
        $prepare = $con->prepare($query);
        return $prepare->execute($this->FieldsAndValues);
    }

    public function save(array $FieldsAndValues): bool
    {
        $this->FieldsAndValues = $FieldsAndValues;
        $query = $this->createQuery();
        try {
            return $this->execute($query);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}

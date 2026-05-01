<?php

namespace app\database\builder;

use app\database\Connection;

class InsertQuery
{
    private string $table;
    private array $FieldsAndValues = [];

    public static function table(string $table): self
    {
        $self = new self;
        $self->table = $table;
        return $self;
    }

    public static function insert(string $table): self
    {
        return self::table($table);
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
        foreach ($this->FieldsAndValues as $key => $value) {
            if (is_bool($value)) {
                $prepare->bindValue(':' . $key, $value, \PDO::PARAM_BOOL);
            } elseif (is_null($value)) {
                $prepare->bindValue(':' . $key, $value, \PDO::PARAM_NULL);
            } else {
                $prepare->bindValue(':' . $key, $value, \PDO::PARAM_STR);
            }
        }
        return $prepare->execute();
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

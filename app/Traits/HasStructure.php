<?php

namespace App\Traits;

trait HasStructure
{
    /**
     * Retorna a estrutura do modelo. Útil para testes.
     *
     * @return int
     */
    public static function getStructure(): array
    {
        return array_keys(with(new static)->attributesToArray());
    }

    /**
     * Retorna o nome da tabela do modelo de maneira estática.
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }
}

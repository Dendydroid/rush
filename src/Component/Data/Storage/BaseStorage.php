<?php

namespace App\Component\Data\Storage;

use App\Component\Data\Entities\BaseEntity;
use ReflectionClass;
use Swoole\Table;

abstract class BaseStorage extends Table
{
    abstract protected function getClass(): string;

    protected function init(): void
    {
        $reflect = new ReflectionClass($this->getClass());
        foreach ($reflect->getProperties() as $property) {
            switch ($property->getType()->getName()) {
                case 'int':
                    $this->column($property->getName(), parent::TYPE_INT, 32);
                    break;
                case 'string':
                    $this->column($property->getName(), parent::TYPE_STRING, 256);
                    break;
                case 'float':
                    $this->column($property->getName(), parent::TYPE_FLOAT);
                    break;
            }
        }
        $this->create();
    }

    public function __construct($table_size, $conflict_proportion = null)
    {
        parent::__construct($table_size, $conflict_proportion);
        $this->init();
    }

    protected function toEntity(?array $data): ?BaseEntity
    {
        if ($data == null) {
            return null;
        }
        $class = $this->getClass();
        $item = new $class();
        foreach ($data as $key => $value) {
            $item->{$key} = $value;
        }
        return $item;
    }

    public function add(BaseEntity $data, ?string $key = null): void
    {
        $this->set($key, $data->toArray());
    }

    public function remove(string $key): void
    {
        $this->delete($key);
    }

    /** @return BaseEntity[] */
    public function getAll()
    {
        $items = [];
        foreach ($this as $value) {
            $items[] = $this->toEntity($value);
        }
        return $items;
    }

    public function getItem(string $key): ?BaseEntity
    {
        $item = $this->get($key);
        return $item ? $this->toEntity($item): null;
    }

    public function update(string $key, BaseEntity $item): void
    {
        $this->set($key, $item->toArray());
    }

    public function clear(): void
    {
        foreach ($this as $id => $value) {
            $this->delete($id);
        }
    }
}

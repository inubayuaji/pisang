<?php

namespace Support\Classes;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Support\Str;

class DataTransferObject
{
    public function __construct(array $args)
    {
        $class = new ReflectionClass($this);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $this->{$property->name} = $args[$property->name] ?? $this->{$property->name} ?? null;
        }
    }

    public function toArray()
    {
        $data = [];
        $class = new ReflectionClass($this);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $data[$property->name] = $this->{$property->name};
        }

        return $data;
    }

    public function toSnake()
    {
        $data = [];
        $class = new ReflectionClass($this);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $data[Str::snake($property->name)] = $this->{$property->name};
        }

        return $data;
    }
}

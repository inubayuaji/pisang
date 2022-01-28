<?php

namespace Support\Classes;

use ReflectionClass;
use ReflectionProperty;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Support\Attributes\MapTo;
use Support\Attributes\RequestName;

class DataTransferObject implements Arrayable
{
    public function __construct(array | Request $args)
    {
        $class = new ReflectionClass($this);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        if (is_array($args)) {
            foreach ($properties as $property) {
                $this->{$property->name} = $args[$property->name] ?? $this->{$property->name} ?? null;
            }
        }

        if (is_object($args)) {
            foreach ($properties as $property) {
                $mapToAttribute = $property->getAttributes(RequestName::class);

                if ($mapToAttribute) {
                    $requestName = $mapToAttribute[0]->newInstance()->name;
                    $this->{$property->name} = $args->{$requestName} ?? $this->{$property->name} ?? null;
                } else {
                    $this->{$property->name} = $this->{$property->name} ?? null;
                }
            }
        }
    }

    public function toArray()
    {
        $data = [];
        $class = new ReflectionClass($this);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $mapToAttribute = $property->getAttributes(MapTo::class);
            $name = count($mapToAttribute) ? $mapToAttribute[0]->newInstance()->name : $property->getName();

            $data[$name] = $this->{$property->name};
        }

        return $data;
    }
}

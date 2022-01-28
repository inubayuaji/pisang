<?php

namespace Support\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class RequestName
{
    public function __construct(public string $name)
    {
    }
}

<?php

namespace PHPMaker2024\sgq\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Put extends Map
{
    /**
     * Constructor
     *
     * @param mixed $args
     */
    public function __construct(...$args)
    {
        parent::__construct("PUT", ...$args);
    }
}

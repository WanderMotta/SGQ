<?php

namespace PHPMaker2024\sgq;

/**
 * Crosstab column class
 */
class CrosstabColumn
{

    public function __construct(
        public $Caption,
        public $Value,
        public $Visible = true,
    ) {
    }
}

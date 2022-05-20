<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

abstract class Component
{
    use SelfCreate;

    /**
     * @var array
     */
    private array $attrs = [];

    /**
     * @var string|null
     */
    private ?string $contents = null;
}

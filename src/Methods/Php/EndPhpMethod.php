<?php

namespace Corviz\Crow\Methods\Php;

use Corviz\Crow\Method;

class EndPhpMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return ' ?>';
    }
}

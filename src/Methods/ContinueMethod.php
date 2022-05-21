<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Method;

class ContinueMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return '<?php '.($parameters ? "if ($parameters)" : '').' continue; ?>';
    }
}

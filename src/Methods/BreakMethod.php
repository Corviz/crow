<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Method;

class BreakMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'break';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return '<?php '.($parameters ? "if ($parameters)" : '').' break; ?>';
    }
}
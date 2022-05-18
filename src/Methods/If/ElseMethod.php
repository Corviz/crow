<?php

namespace Corviz\Crow\Methods\If;

use Corviz\Crow\Method;

class ElseMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'else';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php } else { ?>";
    }
}
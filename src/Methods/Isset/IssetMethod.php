<?php

namespace Corviz\Crow\Methods\Isset;

use Corviz\Crow\Method;

class IssetMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'isset';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php if (isset($parameters)) { ?>";
    }
}
<?php

namespace Corviz\Crow\Methods\Unless;

use Corviz\Crow\Method;

class UnlessMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'unless';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php if (!($parameters)) { ?>";
    }
}
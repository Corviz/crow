<?php

namespace Corviz\Crow\Methods\For;

use Corviz\Crow\Method;

class ForMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'for';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php for($parameters) { ?>";
    }
}
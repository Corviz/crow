<?php

namespace Corviz\Crow\Methods\Empty;

use Corviz\Crow\Method;

class EmptyMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'empty';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php if (empty($parameters)) { ?>";
    }
}
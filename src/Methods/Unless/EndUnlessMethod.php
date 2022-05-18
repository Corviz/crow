<?php

namespace Corviz\Crow\Methods\Unless;

use Corviz\Crow\Method;

class EndUnlessMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'endunless';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php } ?>";
    }
}
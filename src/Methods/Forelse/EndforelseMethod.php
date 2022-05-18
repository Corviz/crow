<?php

namespace Corviz\Crow\Methods\Forelse;

use Corviz\Crow\Method;

class EndforelseMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'endforelse';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php } ?>";
    }
}

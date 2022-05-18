<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Method;

class CheckedMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'checked';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php echo ($parameters) ? 'checked' : '' ?>";
    }
}
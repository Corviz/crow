<?php

namespace Corviz\Crow\Methods\If;

use Corviz\Crow\Method;

class EndIfMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php } ?>";
    }
}

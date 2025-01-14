<?php

namespace Corviz\Crow\Methods\Isset;

use Corviz\Crow\Method;

class EndIssetMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return '<?php } ?>';
    }
}

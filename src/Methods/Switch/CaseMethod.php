<?php

namespace Corviz\Crow\Methods\Switch;

use Corviz\Crow\Method;

class CaseMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php case {$parameters}: ?>";
    }
}

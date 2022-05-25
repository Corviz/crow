<?php

namespace Corviz\Crow\Methods\While;

use Corviz\Crow\Method;

class WhileMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php while ($parameters) { ?>";
    }
}

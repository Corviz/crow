<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Crow;
use Corviz\Crow\Method;

class ExtendsMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'extends';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return "<?php \Corviz\Crow\Crow::queueTemplate($parameters); ?>";
    }
}
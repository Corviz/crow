<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Crow;
use Corviz\Crow\Method;

class IncludeMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'include';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        eval("\$code = \Corviz\Crow\Crow::getTemplateContents($parameters);");
        return $code;
    }
}
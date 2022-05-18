<?php

namespace Corviz\Crow\Methods\Forelse;

use Corviz\Crow\Method;

class ForelseMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'forelse';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        $matches = [];
        preg_match('/\$\w+/m', $parameters ?? '', $matches);
        $v = $matches[0];

        $code = "<?php ";
        $code .= "if (!empty($v)) { ";
        $code .= "foreach($parameters) { ?>";

        $GLOBALS['crowte_forelse'] = true;

        return $code;
    }
}
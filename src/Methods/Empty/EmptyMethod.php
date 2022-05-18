<?php

namespace Corviz\Crow\Methods\Empty;

use Corviz\Crow\Method;

class EmptyMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'empty';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        $code = "<?php if (empty($parameters)) { ?>";

        if (isset($GLOBALS['crowte_forelse'])) {
            $code = "<?php }} else { ?>";
            unset($GLOBALS['crowte_forelse']);
        }

        return $code;
    }
}
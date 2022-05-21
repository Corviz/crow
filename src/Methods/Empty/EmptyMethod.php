<?php

namespace Corviz\Crow\Methods\Empty;

use Corviz\Crow\Crow;
use Corviz\Crow\Method;

class EmptyMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        $code = "<?php if (empty($parameters)) { ?>";

        if (Crow::data('forelse')) {
            $code = "<?php }} else { ?>";
            Crow::removeData('forelse');
        }

        return $code;
    }
}

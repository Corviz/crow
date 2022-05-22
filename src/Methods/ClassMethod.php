<?php

namespace Corviz\Crow\Methods;

class ClassMethod extends \Corviz\Crow\Method
{

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        $code = 'class="<?php ';
        $code .= "foreach($parameters as \$__cclassname => \$__ccheck) {";
        $code .= 'if ($__ccheck) echo $__cclassname, \' \'; ';
        $code .= '} ?>"';
        return $code;
    }
}
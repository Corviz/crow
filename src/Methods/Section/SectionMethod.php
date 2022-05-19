<?php

namespace Corviz\Crow\Methods\Section;

use Corviz\Crow\Method;

class SectionMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'section';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        eval("\$p = [$parameters];");
        $code = "<?php \Corviz\Crow\SectionsManager::addSection('{$p[0]}', function(){ ?>";

        if (count($p) > 1) {
            $code .= $p[1];
            $code .= "<?php }); ?>";
        }

        return $code;
    }
}
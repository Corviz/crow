<?php

namespace Corviz\Crow\Methods\Section;

use Corviz\Crow\Crow;
use Corviz\Crow\Method;

class SectionMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        eval("\$p = [$parameters];");
        $use = $this->buildUse();
        $code = "<?php \Corviz\Crow\SectionsManager::addSection('{$p[0]}', function() $use { ?>";

        if (count($p) > 1) {
            $code .= $p[1];
            $code .= "<?php }); ?>";
        }

        return $code;
    }

    /**
     * @return string
     */
    private function buildUse(): string
    {
        $use = '';

        $dataKeys = Crow::getDataKeys();
        if (!empty($dataKeys)) {
            $use = 'use ('.implode(',', array_map(fn($k) => "&$$k", $dataKeys)).')';
        }

        return $use;
    }
}
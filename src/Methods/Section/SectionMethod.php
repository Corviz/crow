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
        return "<?php \Corviz\Crow\SectionsManager::addSection($parameters, function(){ ?>";
    }
}
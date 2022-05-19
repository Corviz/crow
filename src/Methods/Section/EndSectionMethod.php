<?php

namespace Corviz\Crow\Methods\Section;

use Corviz\Crow\Method;

class EndSectionMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return 'endsection';
    }

    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parameters = null): string
    {
        return '<?php }); ?>';
    }
}
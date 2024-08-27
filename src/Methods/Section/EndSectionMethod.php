<?php

namespace Corviz\Crow\Methods\Section;

use Corviz\Crow\Method;

class EndSectionMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return '<?php }); ?>';
  }
}

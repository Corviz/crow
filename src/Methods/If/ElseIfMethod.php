<?php

namespace Corviz\Crow\Methods\If;

use Corviz\Crow\Method;

class ElseIfMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php } else if ({$parameters}) { ?>";
  }
}

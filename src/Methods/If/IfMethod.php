<?php

namespace Corviz\Crow\Methods\If;

use Corviz\Crow\Method;

class IfMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php if ({$parameters}) { ?>";
  }
}

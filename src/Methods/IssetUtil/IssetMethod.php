<?php

namespace Corviz\Crow\Methods\IssetUtil;

use Corviz\Crow\Method;

class IssetMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php if (isset({$parameters})) { ?>";
  }
}
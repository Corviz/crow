<?php

namespace Corviz\Crow\Methods\Switch;

use Corviz\Crow\Method;

class DefaultMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php default: ?>";
  }
}

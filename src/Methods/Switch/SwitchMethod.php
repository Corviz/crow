<?php

namespace Corviz\Crow\Methods\Switch;

use Corviz\Crow\Method;

class SwitchMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php switch ({$parameters}) { ?>";
  }
}

<?php

namespace Corviz\Crow\Methods\Switch;

use Corviz\Crow\Method;

class EndSwitchMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php } ?>";
  }
}

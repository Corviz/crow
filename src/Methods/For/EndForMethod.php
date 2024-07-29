<?php

namespace Corviz\Crow\Methods\For;

use Corviz\Crow\Method;

class EndForMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php } ?>";
  }
}

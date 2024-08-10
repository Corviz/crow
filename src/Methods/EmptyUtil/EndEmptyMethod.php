<?php

namespace Corviz\Crow\Methods\EmptyUtil;

use Corviz\Crow\Method;

class EndEmptyMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php } ?>";
  }
}

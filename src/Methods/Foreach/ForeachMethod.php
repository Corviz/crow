<?php

namespace Corviz\Crow\Methods\Foreach;

use Corviz\Crow\Method;

class ForeachMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php foreach({$parameters}) { ?>";
  }
}

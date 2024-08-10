<?php

namespace Corviz\Crow\Methods\NotIsset;

use Corviz\Crow\Method;

class NotIssetMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php if (!isset({$parameters})) { ?>";
  }
}
<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Method;

class YieldMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php \Corviz\Crow\SectionsManager::renderSection({$parameters}); ?>";
  }
}

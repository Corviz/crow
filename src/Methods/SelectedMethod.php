<?php

namespace Corviz\Crow\Methods;

use Corviz\Crow\Method;

class SelectedMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    return "<?php echo ({$parameters}) ? 'selected' : '' ?>";
  }
}

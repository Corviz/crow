<?php

namespace Corviz\Crow\Methods\Forelse;

use Corviz\Crow\Crow;
use Corviz\Crow\Method;

class ForelseMethod extends Method {
  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    $v = explode(' as ', $parameters)[0];

    $code = "<?php ";
    $code .= "if (!empty($v)) { ";
    $code .= "foreach($parameters) { ?>";

    Crow::data('forelse', true);

    return $code;
  }
}

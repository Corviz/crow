<?php

namespace Corviz\Crow\Methods;

class ClassMethod extends \Corviz\Crow\Method {

  /**
   * @inheritDoc
   */
  public function toPhpCode(?string $parameters = null): string {
    $code = 'class="<?php ';
    $code .= "foreach ({$parameters} as \$__cclassname => \$__ccheck) {";
    $code .= 'if (is_bool($__ccheck) and $__ccheck) { echo $__cclassname, \' \'; } ';
    $code .= 'else if (is_numeric($__cclassname)) { echo $__ccheck, \' \'; } ';
    $code .= '} ?>"';
    return $code;
  }
}
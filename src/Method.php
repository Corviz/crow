<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

abstract class Method {
  use SelfCreate;

  /**
   * Php code representing this method
   *
   * @param string|null $parameters
   * @return string
   */
  abstract public function toPhpCode(?string $parameters = null): string;
}

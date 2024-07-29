<?php

namespace Corviz\Crow;

class SectionsManager {
  /**
   * @var array
   */
  private static array $sections = [];

  /**
   * @param string $index
   * @param callable $section
   *
   * @return void
   */
  public static function addSection(string $index, callable $section): void {
    self::$sections[$index] = $section;
  }

  /**
   * @param string $index
   * @return void
   */
  public static function renderSection(string $index) {
    if (isset(self::$sections[$index])) {
      self::$sections[$index]();
    }
  }
}

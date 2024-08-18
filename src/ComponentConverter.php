<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;
use Exception;

class ComponentConverter {
  use SelfCreate;

  /**
   * @var array
   */
  private array $namespacesMap = [];

  /**
   * @var string
   */
  private string $componentsNamespace;

  /**
   * @param string $namespace
   * @param string $prefix
   * @return ComponentConverter
   * @throws Exception
   */
  public function addComponentsNamespace(string $namespace, string $prefix = 'default'): ComponentConverter {
    if (isset($this->namespacesMap[$prefix])) {
      throw new Exception("The prefix '$prefix' is registered already");
    }

    $this->namespacesMap[$prefix] = trim($namespace, '\\');
    return $this;
  }

  /**
   * @param string $componentsNamespace
   *
   * @return ComponentConverter
   */
  public function setComponentsNamespace(string $componentsNamespace): ComponentConverter {
    return $this->addComponentsNamespace($componentsNamespace);
  }

  /**
   * @param string $template
   *
   * @return void
   */
  public function toPhp(string &$template): void {
    do {
      $count = 0;
      $template = preg_replace_callback(
        '/<(x-[\w.-]+)([^\/>]*?)(\/>|>((?:(?!<\/?\1\b).|(?R))*)<\/\1>)/s',
        function ($match) {
          $code = "";
          $componentClassName = $this->getComponentClass($match[1]);
          $contents = $match[4] ?? null;

          $attrsArrayCode = $this->attrsStringToArrayCode($match[2] ?? null);

          if (class_exists($componentClassName)) {
            if ($contents) {
              $code .= "<?php ob_start(); ?>$contents<?php \$__componentContents = ob_get_contents(); ob_end_clean(); ?>";
            }

            $code .= "<?php ";
            $code .= "\$__component = $componentClassName::create()";
            $code .= "->setAttributes($attrsArrayCode)";

            if ($contents) {
              $code .= "->setContents(\$__componentContents)";
            }

            $code .= "->render();";
            $code .= " ?>";
          }
          else {
            $code .= "Component class not found: $componentClassName";
          }

          return $code;
        },
        $template,
        count: $count
      );
    } while ($count > 0);
  }

  /**
   * @param string $str
   *
   * @return string
   */
  private function dashToUpperCamelCase(string $str) {
    return ucfirst($this->dashToCamelCase($str));
  }

  /**
   * @param string $str
   *
   * @return string
   */
  private function dashToCamelCase(string $str): string {
    return preg_replace_callback('/-(\w)/', function ($match) {
      return mb_strtoupper($match[1]);
    }, $str);
  }

  /**
   * @param string|null $componentAttrs
   *
   * @return string
   */
  private function attrsStringToArrayCode(?string $componentAttrs): string {
    $code = '[';

    if (!is_null($componentAttrs)) {
      $re = '/(:?\w+)(=("[^"]+"))?/s';

      preg_match_all($re, $componentAttrs, $matches, PREG_SET_ORDER);

      foreach ($matches as $match) {
        $has_placeholder = str_starts_with($match[1], ':');
        $index = $has_placeholder ? substr($match[1], 1) : $match[1]; // $this->dashToCamelCase($match[1]);
        $value = $match[3] ? ($has_placeholder ? trim($match[3], "\"'") : $match[3]) : "''";

        $code .= "'$index' => $value, ";
      }
    }

    $code .= ']';

    return $code;
  }

  /**
   * @param string $componentTagName
   *
   * @return string|null
   */
  private function getComponentClass(string $componentTagName): ?string {
    $pieces = explode('.', substr($componentTagName, 2));
    $className = $this->dashToUpperCamelCase(array_pop($pieces));
    $namespace = $this->namespacesMap['default'] ?? '';

    if (!empty($pieces)) {
      do {
        $currentIndex = implode('.', $pieces);

        if (isset($this->namespacesMap[$currentIndex])) {
          $namespace = $this->namespacesMap[$currentIndex];
          break;
        }

        $className = $this->dashToUpperCamelCase(array_pop($pieces)) . '\\' . $className;
      } while (!empty($pieces));
    }

    return !empty($namespace) ? "\\{$namespace}\\{$className}" : "\\{$className}";
  }
}

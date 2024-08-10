<?php

namespace Corviz\Crow;

use Closure;
use Corviz\Crow\Methods;
use Exception;

class Crow {
  /**
   * @const DEFAULT_EXTENSION
   */
  public const DEFAULT_EXTENSION = '.crow.php';

  /**
   * @const DEFAULT_METHODS
   */
  private const DEFAULT_METHODS = [
    'empty' => Methods\EmptyUtil\EmptyMethod::class,              // // (Empty) itself causes error, so decided to suffix it.
    'endempty' => Methods\EmptyUtil\EndEmptyMethod::class,        // // (Empty) itself causes error, so decided to suffix it.
    'for' => Methods\For\ForMethod::class,
    'endfor' => Methods\For\EndForMethod::class,
    'foreach' => Methods\ForeachUtil\ForeachMethod::class,        // // (Foreach) itself causes error, so decided to suffix it.
    'endforeach' => Methods\ForeachUtil\EndForeachMethod::class,  // // (Foreach) itself causes error, so decided to suffix it.
    'forelse' => Methods\Forelse\ForelseMethod::class,
    'endforelse' => Methods\Forelse\EndforelseMethod::class,
    'if' => Methods\If\IfMethod::class,
    'else' => Methods\If\ElseMethod::class,
    'elseif' => Methods\If\ElseIfMethod::class,
    'endif' => Methods\If\EndIfMethod::class,
    'isset' => Methods\IssetUtil\IssetMethod::class,              // // (Isset) itself causes error, so decided to suffix it.
    'endisset' => Methods\IssetUtil\EndIssetMethod::class,        // // (Isset) itself causes error, so decided to suffix it.
    'notisset' => Methods\NotIsset\NotIssetMethod::class,
    'endnotisset' => Methods\NotIsset\EndNotIssetMethod::class,
    'php' => Methods\Php\PhpMethod::class,
    'endphp' => Methods\Php\EndPhpMethod::class,
    'section' => Methods\Section\SectionMethod::class,
    'endsection' => Methods\Section\EndSectionMethod::class,
    'case' => Methods\Switch\CaseMethod::class,
    'default' => Methods\Switch\DefaultMethod::class,
    'endswitch' => Methods\Switch\EndSwitchMethod::class,
    'switch' => Methods\Switch\SwitchMethod::class,
    'unless' => Methods\Unless\UnlessMethod::class,
    'endunless' => Methods\Unless\EndUnlessMethod::class,
    'while' => Methods\While\WhileMethod::class,
    'endwhile' => Methods\While\EndWhileMethod::class,
    'break' => Methods\BreakMethod::class,
    'checked' => Methods\CheckedMethod::class,
    'class' => Methods\ClassMethod::class,
    'continue' => Methods\ContinueMethod::class,
    'disabled' => Methods\DisabledMethod::class,
    'extends' => Methods\ExtendsMethod::class,
    'include' => Methods\IncludeMethod::class,
    'readonly' => Methods\ReadonlyMethod::class,
    'selected' => Methods\SelectedMethod::class,
    'yield' => Methods\YieldMethod::class,
  ];

  /**
   * @var array
   */
  private static array $pathHashes = [];

  /**
   * @var Closure|null
   */
  private static ?Closure $pathHashingFunction = null;

  /**
   * @var string|null
   */
  private static ?string $cacheFolder = null;

  /**
   * @var array
   */
  private static array $data = [];

  /**
   * @var FileLoader
   */
  private static ?FileLoader $loader = null;

  /**
   * @var CodeConverter
   */
  private static ?CodeConverter $codeConverter = null;

  /**
   * @var ComponentConverter|null
   */
  private static ?ComponentConverter $componentConverter = null;

  /**
   * @var array
   */
  private static array $renderQueue = [];

  /**
   * @param string $file
   * @param array $data
   * @param string|null $path
   *
   * @throws Exception
   * @return void
   */
  public static function render(string $file, array $data = [], ?string $path = null) {
    $cacheFile = null;
    self::data('dataKeys', array_keys($data));
    $isCached = false;

    if (!is_null(self::$cacheFolder)) {
      $folder = 'c' . self::generatePathHash($path);
      $cacheFile = self::$cacheFolder . "/$folder/$file.cache.php";

      $loader = self::getLoader();
      if (is_file($cacheFile) && filemtime($cacheFile) > $loader->getModificationTime($file, $path)) {
        $isCached = true;
      }
    }

    if (!$isCached) {
      $__crowTemplateCode = self::getPhpCode($file, $path);
      self::getComponentConverter()->toPhp($__crowTemplateCode);

      if (!is_null(self::$cacheFolder)) {
        $cacheDir = dirname($cacheFile);
        if (!is_dir($cacheDir)) {
          mkdir($cacheDir, recursive: true);
        }

        if (false === file_put_contents($cacheFile, $__crowTemplateCode)) {
          throw new Exception('Could not write cache file: ' . $cacheFile);
        }
      }

      extract($data);
      eval ("?>$__crowTemplateCode<?php");
    }
    else {
      extract($data);
      require $cacheFile;
    }
  }

  /**
   * @param string $namespace
   * @param string|null $prefix
   * @return void
   * @throws Exception
   */
  public static function addComponentsNamespace(string $namespace, string $prefix = null): void {
    $arguments = [$namespace];

    if (!is_null($prefix)) {
      $arguments[] = $prefix;
    }

    self::getComponentConverter()->addComponentsNamespace(...$arguments);
  }

  /**
   * @param string $method
   * @param string $class
   *
   * @return void
   */
  public static function addMethod(string $method, string $class): void {
    self::getCodeConverter()->addMethod($method, $class);
  }

  /**
   * @param string|null $key
   * @param mixed|null $value
   *
   * @return mixed
   */
  public static function data(string $key = null, mixed $value = null): mixed {
    if (is_null($key) && is_null($value)) return self::$data;
    if (is_null($value)) return self::$data[$key] ?? null;

    self::$data[$key] = $value;
    return null;
  }

  /**
   * @return void
   */
  public static function disableCodeMinifying(): void {
    self::data('options.disable-minifying', true);
  }

  /**
   * @param string $key
   *
   * @return void
   */
  public static function removeData(string $key): void {
    if (isset(self::$data[$key])) unset(self::$data[$key]);
  }

  /**
   * @return string|null
   */
  public static function getExtension(): string {
    return self::getLoader()->getExtension() ?? self::DEFAULT_EXTENSION;
  }

  /**
   * @param string $file
   * @param string|null $path
   *
   * @return string
   * @throws Exception
   */
  public static function getPhpCode(string $file, ?string $path = null): string {
    $code = self::getCodeConverter()->toPhp(
      self::getTemplateContents($file, $path)
    );

    while (!empty(self::$renderQueue)) {
      $tpl = array_pop(self::$renderQueue);
      $code .= self::getCodeConverter()->toPhp(self::getTemplateContents($tpl['file'], $tpl['path']));
    }

    self::minify($code);

    return $code;
  }

  /**
   * @param string $file
   * @param string|null $path
   *
   * @return string
   * @throws Exception
   */
  public static function getTemplateContents(string $file, ?string $path = null): string {
    return self::getLoader()->load($file, $path);
  }

  /**
   * @param string|null $cacheFolder
   */
  public static function setCacheFolder(?string $cacheFolder): void {
    self::$cacheFolder = $cacheFolder;
  }

  /**
   * @param string $namespace
   * @return void
   * @throws Exception
   */
  public static function setComponentsNamespace(string $namespace) {
    self::addComponentsNamespace($namespace);
  }

  /**
   * @param string $path
   * @return void
   */
  public static function setDefaultPath(string $path) {
    self::getLoader()->setDefaultPath($path);
  }

  /**
   * @param string $extension
   * @return void
   */
  public static function setExtension(string $extension) {
    self::getLoader()->setExtension($extension);
  }

  /**
   * @param callable $pathHashingFunction
   *
   * @return void
   */
  public static function setPathHashingFunction(callable $pathHashingFunction): void {
    self::$pathHashingFunction = Closure::fromCallable($pathHashingFunction);
  }

  /**
   * @param string $file
   * @param string|null $path
   *
   * @return void
   */
  public static function queueTemplate(string $file, ?string $path = null) {
    self::$renderQueue[] = compact('file', 'path');
  }

  /**
   * @param string|null $path
   * @return string
   */
  private static function generatePathHash(?string $path): string {
    $path ??= 'default';

    if (!isset(self::$pathHashes[$path])) {
      $hashingFunction = self::$pathHashingFunction ?? 'md5';
      self::$pathHashes[$path] = $hashingFunction($path);
    }

    return self::$pathHashes[$path];
  }

  /**
   * @return CodeConverter
   */
  private static function getCodeConverter(): CodeConverter {
    if (!self::$codeConverter) {
      self::$codeConverter = new CodeConverter();

      // Register all default methods
      foreach (self::DEFAULT_METHODS as $m => $c) {
        self::$codeConverter->addMethod($m, $c);
      }
    }

    return self::$codeConverter;
  }

  /**
   * @return ComponentConverter
   */
  private static function getComponentConverter(): ComponentConverter {
    if (!self::$componentConverter) {
      self::$componentConverter = new ComponentConverter();
    }

    return self::$componentConverter;
  }

  /**
   * @return FileLoader
   */
  private static function getLoader(): FileLoader {
    if (!self::$loader) {
      self::$loader = FileLoader::create()->setExtension(self::DEFAULT_EXTENSION);
    }

    return self::$loader;
  }

  /**
   * @param string $code
   * @return string
   */
  private static function minify(string &$code): void {
    if (self::data('options.disable-minifying')) return;

    $code = str_replace(["\t", "\n", "\r"], ' ', $code);
    $code = preg_replace('/\s{2,}/m', ' ', $code);
    $code = trim($code);
  }
}

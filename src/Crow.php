<?php

namespace Corviz\Crow;

use Corviz\Crow\Methods;
use Exception;

class Crow
{
    public const DEFAULT_EXTENSION = '.crow.php';

    private const DEFAULT_METHODS = [
        Methods\Empty\EmptyMethod::class,
        Methods\Empty\EndEmptyMethod::class,
        Methods\For\ForMethod::class,
        Methods\For\EndForMethod::class,
        Methods\Foreach\ForeachMethod::class,
        Methods\Foreach\EndForeachMethod::class,
        Methods\Forelse\ForelseMethod::class,
        Methods\Forelse\EndforelseMethod::class,
        Methods\If\IfMethod::class,
        Methods\If\ElseMethod::class,
        Methods\If\ElseIfMethod::class,
        Methods\If\EndIfMethod::class,
        Methods\Php\PhpMethod::class,
        Methods\Php\EndPhpMethod::class,
        Methods\Section\SectionMethod::class,
        Methods\Section\EndSectionMethod::class,
        Methods\Unless\UnlessMethod::class,
        Methods\Unless\EndUnlessMethod::class,
        Methods\Unless\EndUnlessMethod::class,
        Methods\BreakMethod::class,
        Methods\CheckedMethod::class,
        Methods\ContinueMethod::class,
        Methods\DisabledMethod::class,
        Methods\ExtendsMethod::class,
        Methods\IncludeMethod::class,
        Methods\SelectedMethod::class,
        Methods\YieldMethod::class,
    ];

    /**
     * @var string|null
     */
    private static ?string $cacheFolder = null;

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
     * @return void
     */
    public static function render(string $file, array $data = [], ?string $path = null)
    {
        $cacheFile = self::$cacheFolder.'/'.$file.'.cache.php';
        if (
            is_null(self::$cacheFolder)
            || (!is_null(self::$cacheFolder) && !is_file($cacheFile))
        ) {
            $code = self::getPhpCode($file, $path);
            self::getComponentConverter()->toPhp($code);

            if (!is_null(self::$cacheFolder)) {
                file_put_contents($cacheFile, $code);
            }

            eval("?>$code<?php");
        } else {
            require $cacheFile;
        }
    }

    /**
     * @param string $file
     * @param string|null $path
     *
     * @return string
     * @throws Exception
     */
    public static function getPhpCode(string $file, ?string $path = null): string
    {
        $code = self::getCodeConverter()->toPhp(
            self::getTemplateContents($file, $path)
        );

        while (!empty(self::$renderQueue)) {
            $tpl = array_pop(self::$renderQueue);

            $code .= self::getCodeConverter()->toPhp(
                self::getTemplateContents($tpl['file'], $tpl['path'])
            );
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
    public static function getTemplateContents(string $file, ?string $path = null): string
    {
        return self::getLoader()->load($file, $path);
    }

    /**
     * @param string|null $cacheFolder
     */
    public static function setCacheFolder(?string $cacheFolder): void
    {
        self::$cacheFolder = $cacheFolder;
    }

    /**
     * @param string $namespace
     * @return void
     */
    public static function setComponentsNamespace(string $namespace)
    {
        self::getComponentConverter()->setComponentsNamespace($namespace);

    }

    /**
     * @param string $path
     * @return void
     */
    public static function setComponentsTemplatesPath(string $path)
    {
        self::getComponentConverter()->setTemplatesPath($path);
    }

    /**
     * @param string $path
     * @return void
     */
    public static function setDefaultPath(string $path)
    {
        self::getLoader()->setDefaultPath($path);
    }

    /**
     * @param string $extension
     * @return void
     */
    public static function setDefaultExtension(string $extension)
    {
        self::getLoader()->setDefaultExtension($extension);
    }

    /**
     * @param string $file
     * @param string|null $path
     *
     * @return void
     */
    public static function queueTemplate(string $file, ?string $path = null)
    {
        self::$renderQueue[] = compact('file', 'path');
    }

    /**
     * @return CodeConverter
     */
    private static function getCodeConverter(): CodeConverter
    {
        if (!self::$codeConverter){
            self::$codeConverter = new CodeConverter();

            //Register all default methods
            foreach (self::DEFAULT_METHODS as $m) {
                self::$codeConverter->addMethod([$m, 'create']());
            }
        }

        return self::$codeConverter;
    }

    /**
     * @return ComponentConverter
     */
    private static function getComponentConverter(): ComponentConverter
    {
        if (!self::$componentConverter){
            self::$componentConverter = new ComponentConverter();
        }

        return self::$componentConverter;
    }

    /**
     * @return FileLoader
     */
    private static function getLoader(): FileLoader
    {
        if (!self::$loader) {
            self::$loader = FileLoader::create()
                ->setDefaultExtension(self::DEFAULT_EXTENSION);
        }

        return self::$loader;
    }

    /**
     * @param string $code
     * @return string
     */
    private static function minify(string &$code): string
    {
        $code = str_replace(["\t", "\n", "\r"], ' ', $code);
        $code = preg_replace('/\s{2,}/m', '', $code);

        return trim($code);
    }
}

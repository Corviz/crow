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
     * @var FileLoader
     */
    private static ?FileLoader $loader = null;

    /**
     * @var CodeConverter
     */
    private static ?CodeConverter $converter = null;

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
        $code = self::getPhpCode($file, $path);
        self::minify($code);

        eval("?>$code<?php");
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
        $code = self::getConverter()->toPhp(
            self::getTemplateContents($file, $path)
        );

        while (!empty(self::$renderQueue)) {
            $tpl = array_pop(self::$renderQueue);

            $code .= self::getConverter()->toPhp(
                self::getTemplateContents($tpl['file'], $tpl['path'])
            );
        }

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
    private static function getConverter(): CodeConverter
    {
        if (!self::$converter){
            self::$converter = new CodeConverter();

            //Register all default methods
            foreach (self::DEFAULT_METHODS as $m) {
                self::$converter->addMethod([$m, 'create']());
            }
        }

        return self::$converter;
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

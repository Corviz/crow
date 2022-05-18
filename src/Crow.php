<?php

namespace Corviz\Crow;

class Crow
{
    public const DEFAULT_EXTENSION = '.crow.php';

    /**
     * @var FileLoader
     */
    private FileLoader $loader;

    /**
     * @param string $file
     * @param array $data
     * @param string|null $extension
     *
     * @return void
     */
    public function render(string $file, array $data = [], string $extension = null)
    {

    }

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->loader = FileLoader::create()
            ->setDefaultExtension(self::DEFAULT_EXTENSION)
            ->setDefaultPath($path);
    }
}

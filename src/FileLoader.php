<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;
use Exception;

class FileLoader
{
    use SelfCreate;

    /**
     * @var string|null
     */
    private ?string $defaultPath = null;

    /**
     * @var string|null
     */
    private ?string $extension = null;

    /**
     *
     * @param string $file
     * @param string|null $path
     *
     * @return string
     * @throws Exception
     */
    public function load(string $file, string $path = null): string
    {
        $path = $path ?? $this->defaultPath ?? '';
        $extension = $this->extension ?? '';

        $filename = "$path/{$file}{$extension}";

        if (!is_file($filename) || !is_readable($filename)) {
            throw new Exception("File is unreadable: '$filename'");
        }

        return file_get_contents($filename);
    }

    /**
     * @param string|null $defaultPath
     * @return FileLoader
     */
    public function setDefaultPath(?string $defaultPath): FileLoader
    {
        $this->defaultPath = $defaultPath;
        return $this;
    }

    /**
     * @param string|null $extension
     * @return FileLoader
     */
    public function setExtension(?string $extension): FileLoader
    {
        $this->extension = $extension;
        return $this;
    }
}

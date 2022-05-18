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
    private ?string $defaultExtension = null;

    /**
     *
     * @param string $file
     * @param string|null $path
     * @param string|null $extension
     *
     * @return string
     * @throws Exception
     */
    public function load(string $file, string $path = null, string $extension = null): string
    {
        $path = $path ?? $this->defaultPath ?? '';
        $extension = $extension ?? $this->defaultExtension ?? '';

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
     * @param string|null $defaultExtension
     * @return FileLoader
     */
    public function setDefaultExtension(?string $defaultExtension): FileLoader
    {
        $this->defaultExtension = $defaultExtension;
        return $this;
    }
}

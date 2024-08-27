<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;
use Exception;

class FileLoader {
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
   * @return string|null
   */
  public function getExtension(): ?string {
    return $this->extension;
  }

  /**
   * @param string $file
   * @param string|null $path
   * @return int|false
   */
  public function getModificationTime(string $file, string $path = null): int|false {
    return filemtime($this->getFilePath($file, $path));
  }

  /**
   *
   * @param string $file
   * @param string|null $path
   *
   * @return string
   * @throws Exception
   */
  public function load(string $file, string $path = null): string {
    $filename = $this->getFilePath($file, $path);

    if (!is_file($filename) || !is_readable($filename)) {
      throw new Exception("File is unreadable: '$filename'");
    }

    return file_get_contents($filename);
  }

  /**
   * @param string|null $defaultPath
   * @return FileLoader
   */
  public function setDefaultPath(?string $defaultPath): FileLoader {
    $this->defaultPath = $defaultPath;
    return $this;
  }

  /**
   * @param string|null $extension
   * @return FileLoader
   */
  public function setExtension(?string $extension): FileLoader {
    $this->extension = $extension;
    return $this;
  }

  /**
   * @param string $file
   * @param string|null $path
   * @return string
   */
  private function getFilePath(string $file, string $path = null) {
    $path ??= $this->defaultPath ?? '';
    $extension = $this->extension ?? '';
    $extension = str_starts_with($extension, '.') ? substr($extension, 1) : $extension;
    $extension = str_ends_with($extension, '.php') ? '.' . rtrim($extension, '.php') : $extension;

    return "{$path}/{$file}{$extension}.php";
  }
}

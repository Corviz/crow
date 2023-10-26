<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

abstract class Component
{
    use SelfCreate;

    /**
     * @var string|null
     */
    protected ?string $templatesPath = null;

    /**
     * @var string|null
     */
    protected ?string $extension = Crow::DEFAULT_EXTENSION;

    /**
     * @var array
     */
    private array $attributes = [];

    /**
     * @var string|null
     */
    private ?string $contents = null;

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string|null
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * @param array $attributes
     * @return Component
     */
    public function setAttributes(array $attributes): Component
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string|null $contents
     * @return Component
     */
    public function setContents(?string $contents): Component
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return void
     */
    abstract public function render(): void;

    /**
     * @param string $file
     * @param array $data
     *
     * @return void
     */
    protected function view(string $file, array $data = []): void
    {
        $data = $data + get_object_vars($this) + [
            'contents' => $this->getContents(),
            'attributes' => $this->getAttributes(),
        ];
        $oldExt = Crow::getExtension();

        Crow::setExtension($this->extension);
        Crow::render($file, $data, $this->templatesPath);
        Crow::setExtension($oldExt);
    }
}

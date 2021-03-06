<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

abstract class Component
{
    use SelfCreate;

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
        $data = $data + [
            'contents' => $this->getContents(),
            'attributes' => $this->getAttributes(),
        ];
        Crow::render($file, $data);
    }
}

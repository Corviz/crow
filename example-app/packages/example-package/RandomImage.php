<?php

namespace ExamplePackage;

use Corviz\Crow\Component;

class RandomImage extends Component
{
    /**
     * @var string|null
     */
    protected ?string $templatesPath = __DIR__.'/template';

    /**
     * @inheritDoc
     */
    public function render(): void
    {
        $this->view('random-image');
    }
}
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
     * @var string|null
     */
    protected ?string $extension = '.blade.php';

    /**
     * @inheritDoc
     */
    public function render(): void
    {
        $this->view('random-image');
    }
}
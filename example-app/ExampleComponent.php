<?php

namespace ExampleApp;

use Corviz\Crow\Component;

class ExampleComponent extends Component
{
    /**
     * @inheritDoc
     */
    public function render(): void
    {
        $data = [
            'message' => 'This is a simple component',
        ];

        $this->view('example-component', $data);
    }
}
<?php

namespace ExampleApp;

use Corviz\Crow\Component;

class ExampleComponent extends Component
{
    public string $message = 'This is a simple component';

    /**
     * @inheritDoc
     */
    public function render(): void
    {
        $data = [
            'anotherMessage' => 'This is another message',
        ];

        $this->view('example-component', $data);
    }
}

<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

abstract class Method
{
    use SelfCreate;

    /**
     * A string representing the method when called inside a template.
     * E.g.: @if would be 'if'; @foreach would be 'foreach'
     *
     * @return string
     */
    abstract public function getSignature(): string;

    /**
     * Php code representing this method
     *
     * @param string|null $parameters
     * @return string
     */
    abstract public function toPhpCode(?string $parameters = null): string;
}

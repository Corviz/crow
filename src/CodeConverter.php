<?php

namespace Corviz\Crow;

use Corviz\Crow\Methods;

final class CodeConverter
{
    /**
     * @var array
     */
    private array $components = [];

    /**
     * @var array
     */
    private array $filters = [];

    /**
     * @var array
     */
    private array $methods = [];

    /**
     * @param string $templateCode
     *
     * @return string
     */
    public function toPhp(string $templateCode): string
    {
        $this->convertComments($templateCode);
        $this->convertEscaped($templateCode);
        $this->convertUnescaped($templateCode);
        $this->convertMethods($templateCode);

        return $templateCode;
    }

    /**
     * @param Method $method
     * @return void
     */
    public function addMethod(Method $method): void
    {
        $this->methods[$method->getSignature()] = $method;
    }

    /**
     * @param string $templateCode
     *
     * @return void
     */
    private function convertEscaped(string &$templateCode): void
    {
        $templateCode = preg_replace(
            '/{{((?:(?!}})\S|\s)+)}}/',
            '<?php echo htmlentities($1) ?>',
            $templateCode
        );
    }

    /**
     * @param string $templateCode
     * @return void
     */
    private function convertUnescaped(string &$templateCode): void
    {
        $templateCode = preg_replace(
            '/{!!((?:(?!!!})\S|\s)+)!!}/',
            '<?php echo $1 ?>',
            $templateCode
        );
    }

    /**
     * @param string $templateCode
     * @return void
     */
    private function convertComments(string &$templateCode): void
    {
        $templateCode = preg_replace(
            '/{{\-\-((?:(?!\-\-}})\S|\s)+)--}}/',
            '<?php /** $1 */ ?>',
            $templateCode
        );
    }

    /**
     * @param string $templateCode
     * @return void
     */
    private function convertMethods(string &$templateCode): void
    {
        $templateCode = preg_replace_callback(
            '/@(\w+)\s*(\(((?:[^()]++|(\g<2>))*)\))?/m',
            function($match){
                if (isset($this->methods[$match[1]])) {
                    /* @var $method Method */
                    $method = $this->methods[$match[1]];

                    return $method->toPhpCode($match[3] ?? null);
                }

                return $match[0];
            },
            $templateCode
        );
    }
}

<?php

namespace Corviz\Crow;

class Conversor
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
        $this->convertEscaped($templateCode);

        return $templateCode;
    }

    /**
     * @param string $templateCode
     *
     * @return void
     */
    public function convertEscaped(string &$templateCode): void
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
    public function convertUnescaped(string &$templateCode)
    {
        $templateCode = preg_replace(
            '/{!!((?:(?!!!})\S|\s)+)!!}/',
            '<?php echo $1 ?>',
            $templateCode
        );
    }
}

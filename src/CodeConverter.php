<?php

namespace Corviz\Crow;

final class CodeConverter
{
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
        while($this->convertMethods($templateCode, 'extends|include'));
        while($this->convertMethods($templateCode));
        $this->convertComments($templateCode);
        $this->convertEscaped($templateCode);
        $this->convertUnescaped($templateCode);

        return $templateCode;
    }

    /**
     * @param string $method
     * @param string $class
     *
     * @return void
     */
    public function addMethod(string $method, string $class): void
    {
        $this->methods[$method] = ['c' => $class, 'i' => null];
    }

    /**
     * @param string $templateCode
     *
     * @return void
     */
    private function convertEscaped(string &$templateCode): void
    {
        $templateCode = preg_replace(
            '/{{(.*?)}}/',
            '<?php echo htmlentities(($1) ?? null) ?>',
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
            '/{!!(.*?)!!}/',
            '<?php echo ($1) ?? null ?>',
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
            '/{{--(.*?)--}}/',
            '<?php /** $1 */ ?>',
            $templateCode
        );
    }

    /**
     * @param string $templateCode
     * @return int
     */
    private function convertMethods(string &$templateCode, string $tag = null): int
    {
        $count = 0;

        if (is_null($tag)) {
            $methods = array_keys($this->methods);
            //Evaluate longer named methods first
            usort($methods, function ($a, $b) {
                $lengthA = strlen($a);
                $lengthB = strlen($b);

                if ($lengthA == $lengthB) return 0;

                return $lengthB > $lengthA ? 1 : -1;
            });
            $tag = implode('|', $methods);
        }

        $templateCode = preg_replace_callback(
            '/@('.$tag.')\s*(\(((?:[^()]++|(\g<2>))*)\))?/m',
            function($match){
                if (isset($this->methods[$match[1]])) {
                    if (!$this->methods[$match[1]]['i']) {
                        $this->methods[$match[1]]['i'] = $this->methods[$match[1]]['c']::create();
                    }

                    /* @var $method Method */
                    $method = $this->methods[$match[1]]['i'];

                    return $method->toPhpCode($match[3] ?? null);
                }

                return $match[0];
            },
            $templateCode,
            count: $count
        );

        return $count;
    }
}

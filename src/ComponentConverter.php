<?php

namespace Corviz\Crow;

use Corviz\Crow\Traits\SelfCreate;

class ComponentConverter
{
    use SelfCreate;

    /**
     * @var string
     */
    private string $componentsNamespace;

    /**
     * @param string $componentsNamespace
     * @return ComponentConverter
     */
    public function setComponentsNamespace(string $componentsNamespace): ComponentConverter
    {
        $this->componentsNamespace = trim($componentsNamespace, '\\');
        return $this;
    }

    /**
     * @param string $template
     *
     * @return void
     */
    public function toPhp(string &$template): void
    {
        do {
            $count = 0;
            $template = preg_replace_callback(
                '/<(x-(\w|-)+)([^\/>]*?)(\/>|>(.*?)<\/\g<1>>)/s',
                function($match) {
                    $code = "";
                    $componentName = substr($match[1], 2);
                    $componentClassName =
                        '\\'.$this->componentsNamespace
                        .'\\'. $this->dashToUpperCamelCase($componentName).'Component';
                    $contents = $match[5] ?? null;

                    $attrsArrayCode = $this->attrsStringToArrayCode($match[3] ?? null);

                    if (class_exists($componentClassName)) {
                        $code .= "<?php ob_start(); ?>$contents<?php \$__componentContents = ob_get_contents(); ob_end_clean(); ?>";
                        $code .= "<?php ";
                        $code .= "\$__component = $componentClassName::create()";
                        $code .= "->setAttributes($attrsArrayCode)";
                        if ($contents) {
                            $code .= "->setContents(\$__componentContents)";
                        }
                        $code .= "->render();";
                        $code .= " ?>";
                    } else {
                        $code .= "Component class not found: $componentClassName";
                    }

                    return $code;
                },
                $template,
                count: $count
            );
        } while ($count > 0);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    private function dashToUpperCamelCase(string $str)
    {
        return ucfirst($this->dashToCamelCase($str));
    }

    /**
     * @param string $str
     *
     * @return string
     */
    private function dashToCamelCase(string $str): string
    {
        return preg_replace_callback('/-(\w)/', function($match){
            return mb_strtoupper($match[1]);
        }, $str);
    }

    /**
     * @param string|null $componentAttrs
     *
     * @return string
     */
    private function attrsStringToArrayCode(?string $componentAttrs): string
    {
        $code = '[';

        if (!is_null($componentAttrs)) {

            $re = '/((:?)((\w|-)+))(="((?:[^"]++|\g<4>)(.*?))")?/s';
            $str = ' nome="Abc" :data-atual="!$teste || date(\'Y-m-d\') && $valid == true" teste';

            preg_match_all($re, $componentAttrs, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $index = $this->dashToCamelCase($match[3]);
                $value = 'true';
                $isString = empty($match[2]);

                if (!empty($match[6])) {
                    $value = $match[6];

                    if ($isString) {
                        $value = "'$value'";
                    }
                }

                $code .= "'$index' => $value,";
            }
        }

        $code .= ']';

        return $code;
    }
}

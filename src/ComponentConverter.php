<?php

namespace Corviz\Crow;

class ComponentConverter
{
    private int $componentsCount = 0;
    private string $templatesPath;
    private string $componentsNamespace;

    /**
     * @param string $templatesPath
     * @return ComponentConverter
     */
    public function setTemplatesPath(string $templatesPath): ComponentConverter
    {
        $this->templatesPath = $templatesPath;
        return $this;
    }

    /**
     * @param string $componentsNamespace
     * @return ComponentConverter
     */
    public function setComponentsNamespace(string $componentsNamespace): ComponentConverter
    {
        $this->componentsNamespace = $componentsNamespace;
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
                    $this->componentsCount++;
                    $componentName = substr($match[1], 2);
                    $componentClassName = $this->dashToUpperCamelCase($componentName);
                    $attrs = $this->attrsStringToArrayCode($match[3] ?? null);
                    $contents = $match[5] ?? null;

                    $attrsVariableName = '$_componentAttrs'.$this->componentsCount;

                    return "$componentName: ".$this->attrsStringToArrayCode($attrs);
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
//        $re = '/((:?)((\w|-)+))(="((?:[^\\\\"\']++|\g<4>)(.*?))")?/s';
//        $str = ' nome="Abc" :data-atual="!$teste || date(\'Y-m-d\') && $valid == true" teste';
//
//        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

// Print the entire match result
        //var_dump($matches);

//        return print_r($matches, true);
        $code = '[';

        if (!is_null($componentAttrs)) {

            $re = '/((:?)((\w|-)+))(="((?:[^\\\\"]++|\g<4>)(.*?))")?/s';
            preg_match_all($re, $componentAttrs, $matches, PREG_SET_ORDER, 0);
            //preg_match_all('/((:?)((\w|-)+))(="((?:[^\\\\"\']++|\g<4>)(.*?))")?/s', $componentAttrs, $matches, PREG_SET_ORDER, 0);

            $code .= print_r($matches, true);
            //for ($i = 0; $i < count($matches[0]); $i++) {
//                $index = $matches[3][$i];
//                $value = 'true';
//                $isString = empty($matches[2][$i]);
//
//                if (!empty($matches[6][$i])) {
//                    $value = $matches[6][$i];
//
//                    if ($isString) {
//                        $value = "'$value'";
//                    }
//                }
//
//                //$code .= "'$index' => $value,";
            //}
        }

        $code .= '];';

        return $code;
    }
}

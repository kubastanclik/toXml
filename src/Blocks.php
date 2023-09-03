<?php
namespace Stanclik\ToXml;
class Blocks
{
    public const US_ASCII = 'US-ASCII';
    public const UTF_8 = 'UTF-8';
    public const ISO_10646 = 'ISO-10646-UCS-4';
    public const EBCDIC = 'ebcdic-cp-us';
    public const IBM = 'ibm1140';
    public const ISO_8859 = 'ISO-8859-1';
    public const WINDOWS = 'windows-1252';

    /**
     * @param $params
     * @return string
     */
    public static function header($params): string
    {

        $parsedParams = array_map(static function($key, $param) {
            return $key . '="' . $param . '"';
        }, array_keys($params), array_values($params));

        $parsedParams = trim(implode(' ', $parsedParams));

        return "<?xml $parsedParams?>" . PHP_EOL;
    }

    /**
     * @param string $name
     * @param array $blocks
     * @param array $params
     * @param string $nameSpace
     * @return string
     */
    public static function tag(string $name, array $blocks = [], array $params = [], string $nameSpace = ''): string
    {

        $parsedParams = array_map(static function($key, $param) {
            return $key . '="' . $param . '"';
        }, array_keys($params), array_values($params));

        $parsedParams = trim(implode(' ', $parsedParams));

        $tagContent = [];

        foreach ($blocks as $block) {
            $tagContent[] = $block;
        }

        $tagContent = implode(PHP_EOL, $tagContent);

        if (empty($tagContent)) {
            return "\t<{$nameSpace}{$name} {$parsedParams}/>";
        }

        return "\t<{$nameSpace}{$name} {$parsedParams}>\n{$tagContent}\n\t</{$nameSpace}{$name}>";
    }

    /**
     * @param string $value
     * @param bool $useCdata
     * @return string
     */
    public static function content(string $value, bool $useCdata = true): string
    {
        if ($useCdata) {
            return "\t\t<![CDATA[" . $value . "]]>";
        }

        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    public static function raw(string $value): string
    {
        return $value;
    }
}
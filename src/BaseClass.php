<?php
namespace Stanclik\ToXml;
/**
 *  Base Class
 */
class BaseClass
{
    /**
     * @var array
     */
    private array $params;
    /**
     * @var string
     */
    private String $xml;
    /**
     * @var array
     */
    private array $rootNode = [];
    /**
     * @var string
     */
    private String $header = '';
    /**
     * @var String
     */
    private String $rendered;

    /**
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;

        $this->xml = '';

        $this->init();
    }

    /**
     * @return void
     */
    public function init(): void
    {
        foreach ($this->params as $param) {
            $param;
        }
    }

    /**
     * @param String $node
     * @param array $params
     * @return $this
     */
    public function root(String $node, array $params = []): BaseClass
    {
        if (!empty($params)) {

            $parsedParams = $this->parseParameters($params);

            $this->rootNode[0] = "<{$node} {$parsedParams}>";
            
            $this->rootNode[1] = "</{$node}>";

            return $this;
        };

        $this->rootNode[0] = "<{$node}>";

        $this->rootNode[1] = "</{$node}>";

        return $this;
    }

    /**
     * @param $header
     * @return void
     */
    public function setHeaders($header): void
    {
        $this->header .= $header . PHP_EOL;
    }

    /**
     * @param $params
     * @return string
     */
    private function parseParameters($params): string
    {
        $parsedParams = array_map(function($key, $param) {
            return $key . '="' . $param . '"';
        }, array_keys($params), array_values($params));

        return trim(implode(' ', $parsedParams));
    }

    /**
     * @param ...$blocks
     * @return $this
     */
    public function add(...$blocks): BaseClass
    {
        $temporary = [];

        foreach ($blocks as $block) {
            $temporary[] = $block;
        }

        $xmlContent = implode("\n", $temporary);

        $this->xml .= $xmlContent;

        return $this;
    }

    /**
     * @return $this
     */
    public function render(): BaseClass
    {
        $this->rendered = "{$this->header}{$this->rootNode[0]}\n{$this->xml}\n{$this->rootNode[1]}";

        return $this;
    }

    /**
     * @return void
     */
    public function print(): void
    {
        echo $this->rendered;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->rendered;
    }
}
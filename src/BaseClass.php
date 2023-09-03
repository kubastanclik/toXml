<?php
namespace Stanclik\ToXml;
class BaseClass
{
    private array $params;
    private String $xml;
    private array $rootNode = [];
    private String $header = '';
    private String $rendered;
    public function __construct($params)
    {
        $this->params = $params;

        $this->xml = '';

        $this->init();
    }

    public function init(): void
    {
        foreach ($this->params as $param) {
            $param;
        }
    }

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

    public function setHeaders($header): void
    {
        $this->header .= $header . PHP_EOL;
    }

    private function parseParameters($params): string
    {
        $parsedParams = array_map(function($key, $param) {
            return $key . '="' . $param . '"';
        }, array_keys($params), array_values($params));

        return trim(implode(' ', $parsedParams));
    }

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

    public function render(): BaseClass
    {
        $this->rendered = "{$this->header}{$this->rootNode[0]}\n{$this->xml}\n{$this->rootNode[1]}";

        return $this;
    }

    public function print(): void
    {
        echo $this->rendered;
    }

    public function get(): string
    {
        return $this->rendered;
    }
}
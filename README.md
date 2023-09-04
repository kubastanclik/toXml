
# toXML

An easy-to-use library for generating XML files.



[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)



## Installation

Install usign composer

```bash
  composer require stanclik/toxml
```
    
## Usage/Examples

```php
require 'vendor/autoload.php';
use \Stanclik\ToXml\ToXml;
use \Stanclik\ToXml\Blocks;

$xml = new ToXml([]);

// set document header
$xml->setHeaders(Blocks::header(['version' => '1.0', 'encoding' => Blocks::UTF_8]));
// set root element
$xml->root('offers', ['param' => 'foo']);
$xml->add(
    Blocks::tag('item', [ // set item
        Blocks::tag('name', [Blocks::content('Some item')]),
        Blocks::tag('description', [Blocks::content('Some description')]),
        Blocks::tag('attributes', [ // set nested elements
            Blocks::tag('some-attribute', [], ['params' => 'foo']),
            Blocks::tag('some-attribute', [], ['params' => 'foo']),
            Blocks::tag('some-attribute', [], ['params' => 'foo']),
        ])
    ])
);
// call method to render xml;
$xml->render();

// print xml as a string;
header('Content-type: application/xml');
$xml->print();

// return xml as a string
$xml->get();
```

### Result:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<offers param="foo">
    <item>
        <name>
            <![CDATA[ Some item ]]>
        </name>
        <description>
            <![CDATA[ Some description ]]>
        </description>
        <attributes>
            <some-attribute params="foo"/>
            <some-attribute params="foo"/>
            <some-attribute params="foo"/>
        </attributes>
    </item>
</offers>
```

## Blocks

#### Header
```php
Blocks::header([
    'version' => '1.0' // add header on start of the content
])
```

#### Tag
```php
Blocks::tag(
    'tag-name' // tag name ex: <tag-name>
    [
        // nested tags
    ],
    [
        'param' => 'foo' // params ex: <tag-name params="foo">
    ]
)
```

#### Content

```php
Blocks::content(
    'Lorem Ipsum' // content inside the element,
    true|false // wrap the content in CDATA tags
)
```

#### Raw
```php
Blocks::raw(
    '<tag><!CDATA[some stuff]]>' // just add raw tag
)
```

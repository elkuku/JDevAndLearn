# Fenced Code

Demo text... Plain

```
echo 'Foo';
echo "Bar";
```

Demo text... PHP

```php
echo 'FooBar';
echo "BazQuirk";

$content = new stdClass;
$page = JFactory::getApplication()->input->getVar('page', 'start');
$fullPath = MGW_PATH_DATA.'/'.$page.'.md';
$path = realpath($fullPath);

foreach($foo as $bar => $baz)
{
    echo sprintf('Yoh, %s dooh %d gulash', $bar, $baz);
}

exit(666);
```

Inline ```Demo Test``` Text

<hr />

Happy coding ```=;)```

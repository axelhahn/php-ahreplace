## Create a tagfile

You need a file with replacements or use the method addTag() to add your own dynamic replacements.

But to start simple we use a text file `hello.txt`with static replacements.

```txt
{{PROJECT}} := Test project
{{GREETNG}} := Hello World! Welcome to my <strong>{{PROJECT}}</strong>.
```
## Create a content file

We need a content file to apply the replacements to - `example_content.txt`.

```txt
<h1>Example</h1>
{{GREETING}}
```

## Include the class

Let's include the class and initalize it:

```php
<?php 
require_once __DIR__.'/../src/replace-tags.class.php';
$oReplace=new axelhahn\ReplaceTags();
```

Then we load our replacements.

```php
$oReplace->readTagfile(__DIR__.'/hello.txt');

// or just optional:
// $oReplace->addTag('{{LICENSE}}', 'GNU GPL 3');
```

Finally we need the source text containing a placeholder. We need to load it and apply the replacements.

```php
$sSource=file_get_contents(__DIR__.'/example_content.txt');
$oReplace->doReplace($sOut, 2);
```

## Continue

Not only static replacements but also dynamic ones can be added.
See the next page...

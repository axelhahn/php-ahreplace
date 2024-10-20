## Introduction

### How you can add tags

* use static files containing key/value pairs
* use the method addTag()

### What you can define

You can replace

* simple static placeholders
* placeholders with variables

### How to add replacements

#### Files

You can write replacements in one or multiple text files and load them with 

```php
$oReplace=new axelhahn\ReplaceTags();
$oReplace->readTagfile(<FILE_1>);
$oReplace->readTagfile(<FILE_N>);
```

You get the idea: in files you can group your replacements and import only the needed files.

The syntax is:

```text
; I am a comment
[Tag] := [Replacement]
```

Rules:

* Lines starting with `;` are **comments** and will be ignored
* **Tag** is the part in front of the devider; spaces will be trimmed.
* The **devider** is always `:=`
* The **replacement** 
  * is the part behind the devider
  * spaces will be trimmed.
  * can be multiline

#### By method addTag()

You can add replacements with the method `addTag()`.
With it you can add more replacements. It can be used if you have dynamic output data that cannot be written in a static file.

The syntax is:

```php
$oReplace=new axelhahn\ReplaceTags();
// optional:
// $oReplace->readTagfile(<FILE_1>);
$this->addTag('{{PROJECT_VERSION}}', $this->_sVersion);
```

## What you can define

### Simple static placeholders

This is the mos simple variant: you define a strng that will be replaced with something else.

To prevent worng replaces you need to define a keyword that is somehow uniqe in your texts. 

**Recommendation**: 

Surround a string somehow - eg. with an double underscore like `__PROJECTID__` (for project name) or brackets `{{PROJECTID}}`

### Overrides

If you imagine that all replacements are handled top down. You should define the most simple keywords first. In a later replacement you can use already defined keys as a variable.

A small example illustrates this:

```txt
__PRJ__     := ahcrawler
__URLGIT__  := https://github.com/axelhahn/__PRJ__.git
__URLZIP__  := https://github.com/axelhahn/__PRJ__/archive/refs/heads/master.zip
```

### Placeholders with variables

Next to the simple static placeholders you can use variables.

Syntax:

```text
;   with arguments: use double quotes and introduce a variable with "$" 
;   character:
[Tag "$arg1[,..$argN]"] := [Replacement_with_$arg1...$argN]
```

* In your key (before the delimter `:=`) use double quotes
* Inside these double quotes you can use `$` and a string for a variable like `$<VARNAME>`
* You also can use multiple variables: use a `,`as delimiter like `$<VARNAME1>,$<VARNAME2>`
* Override: in dependency of the count of variables the right replacement ()

EXAMPLE:

We define a wrapper `[IMG "..."]` for an image tag in a file. 

```text
[IMG "$img"]    := 

		<!-- image with alt text -->
		<br />
		<img src="$img" class="screenshot" alt="image $img"><br />


[IMG "$img,$alt"]    := 

		<!-- image with alt text -->
		<br />
		<img src="$img" class="screenshot" alt="$alt"><br />

```

If your source content you can use now both variants: `[img ".."]` with one or two arguments:

```text
[img "/asstes/images/example.png"]
[img "/asstes/images/example.png","My alt title"]
```

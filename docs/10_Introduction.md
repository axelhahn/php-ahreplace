## Introduction

A PHP class to replace text elements and handle replacements.

The elements for replacements are kind of global replacements for the content
of your website, documentation, ... 

You can use static replacement snippets, snippets with variables.
The replacements can be put in a file or you can add them dynamically with addTag() method in your code.

You can

* replace simple keywords with text (but for that you wouldn't need the class)
* cascade replacements
* use "parameters" in a replacement

The data what to to replace how can be read from multiple files to include
global replacements and more specific replacements for a project or a dependenncy.

This class can be useful in a parser or pre processor.

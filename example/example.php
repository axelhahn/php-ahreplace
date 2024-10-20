<?php 

require_once __DIR__.'/../dist/replace-tags.class.php';

$oReplace=new axelhahn\ReplaceTags();
$oReplace->readTagfile(__DIR__.'/taglist.txt');
$oReplace->readTagfile(__DIR__.'/taglist_project.txt');

//$oReplace->dump();
// example for adding replacements with a method
// $oReplace->addTag('__LICENSE__', 'GNU GPL 3');


$sSource=file_get_contents(__DIR__.'/example_content.txt');
echo "----- source: \n$sSource";


$sOut=$sSource;
$sOut=$oReplace->doReplace($sOut, 2);

echo "\n\n----- output: \n$sOut";

## Class axelhahn\ReplaceTags

```txt

```

## Properties

(none)

## Methods

### public __construct


constructor


**Parameters**: **1** (required: 0)

| Parameter | Type | Description
|--         |--    |--
\<optional\> string $sTagfile = '' | string | optional: filename of a custom tagfile



**Return**: boolean *

### public addTag


add a tag for replacement


**Parameters**: **2** (required: 2)

| Parameter | Type | Description
|--         |--    |--
\<required\> string $sTag | string | Keyword for replacement
\<required\> string $sReplace | string | Text to replace



**Return**: bool

### public doReplace


Replace the tags in a given text according to the tags-array



**Parameters**: **2** (required: 1)

| Parameter | Type | Description
|--         |--    |--
\<required\> string $line | string | the text we want to process
\<optional\> int $iRuns = 1 | int | optional: repeats; default: 1 run



**Return**: string

### public dump


Show all defined tags


**Parameters**: **0** (required: 0)



**Return**: void

### public getTags


Return all defined tags


**Parameters**: **0** (required: 0)



**Return**: array

### public readTagfile


read the taglist, parse it and create a tag array


**Parameters**: **1** (required: 0)

| Parameter | Type | Description
|--         |--    |--
\<optional\> string $sTagfile = '' | string | optional: filename of a custom tagfile



**Return**: bool



---
Generated with Axels PHP class doc parser.
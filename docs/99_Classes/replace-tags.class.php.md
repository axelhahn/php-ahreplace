---
title: axelhahn\ReplaceTags
generator: Axels php-classdoc; https://github.com/axelhahn/php-classdoc
---

## 📦 Class axelhahn\ReplaceTags

```txt

```

## 🔶 Properties

(none)

## 🔷 Methods

### 🔹 public __construct()

constructor

Line [32]() (6 lines)

**Return**: `boolean *`

**Parameters**: **1** (required: 0)

| Parameter | Type | Description
|--         |--    |--
| \<optional\> $sTagfile | `string` | optional: filename of a custom tagfile

### 🔹 public addTag()

add a tag for replacement

Line [105]() (8 lines)

**Return**: `bool`

**Parameters**: **2** (required: 2)

| Parameter | Type | Description
|--         |--    |--
| \<required\> $sTag | `string` | Keyword for replacement
| \<required\> $sReplace | `string` | Text to replace

### 🔹 public readTagfile()

read the taglist, parse it and create a tag array

Line [119]() (63 lines)

**Return**: `bool`

**Parameters**: **1** (required: 0)

| Parameter | Type | Description
|--         |--    |--
| \<optional\> $sTagfile | `string` | optional: filename of a custom tagfile

### 🔹 public dump()

Show all defined tags

Line [188]() (4 lines)

**Return**: `void`

**Parameters**: **0** (required: 0)

### 🔹 public getTags()

Return all defined tags

Line [197]() (4 lines)

**Return**: `array`

**Parameters**: **0** (required: 0)

### 🔹 public doReplace()

Replace the tags in a given text according to the tags-array

Line [209]() (30 lines)

**Return**: `string`

**Parameters**: **2** (required: 1)

| Parameter | Type | Description
|--         |--    |--
| \<required\> $line | `string` | the text we want to process
| \<optional\> $iRuns | `int` | optional: repeats; default: 1 run

---
Generated with [Axels PHP class doc parser](https://github.com/axelhahn/php-classdoc)

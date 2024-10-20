<?php
/**
 * REPLACE TAGS
 * 
 * Class for text replacement by using text sources for pre defined tags.
 * 
 * It is inspired by the replacer in PHPCMS (a former flat file cms/ parser)
 * 
 */
namespace axelhahn;

class ReplaceTags
{

    /**
     * Array of known tags and placeholders to replace
     * @var array
     */
    private array $_aTags = [];

    /**
     * Filename of a custom tagfile
     * @var string
     */
    private string $sTagfile = "taglist.txt";

    /**
     * constructor
     * @param  string  $sTagfile  optional: filename of a custom tagfile
     * @return boolean
     */
    function __construct(string $sTagfile = '')
    {
        if ($sTagfile) {
            $this->readTagfile($sTagfile);
        }
    }

    // ----------------------------------------------------------------------
    // PRIVATE FUNCTONS
    // ----------------------------------------------------------------------

    /**
     * This method processes a line of text and replaces the given tag inside of it
     *
     * @param string   $sFrom   key name of the tag we have to replace
     * @param string   $sTo     value value of tag we have to replace
     * @param string   $line    line the text we have to process
     * @return string the processed text
     */
    private function _tag_value_replace(string $sFrom, string $sTo, string $line): string
    {
        $oldval = $sTo;
        $Tag_Start = substr($sFrom, 0, strpos($sFrom, '"'));

        if (strpos($line, $Tag_Start . '"') === false) {
            return $line;
        }

        // set Tag-Variables
        $Tag_Vars = substr($sFrom, strpos($sFrom, '"') + 1);
        // set Tag-End
        $Tag_End = substr($Tag_Vars, strpos($Tag_Vars, '"') + 1);
        $Tag_Vars = substr($Tag_Vars, 0, strpos($Tag_Vars, '"'));

        // find Tag-begin in Line
        // put all before the Tag in temp-variable $PartOne
        $PartOne = substr($line, 0, strpos($line, $Tag_Start . '"'));
        $PartTwo = substr($line, strpos($line, $Tag_Start . '"') + strlen($Tag_Start . '"') + 1);

        // put all after the Tag in temp-variable $PartTwo
        $PartTwo = substr($PartTwo, strpos($PartTwo, $Tag_End) + strlen($Tag_End));
        $ToReplace = substr($line, strpos($line, $Tag_Start) + strlen($Tag_Start) + 1);

        $ToReplace = substr($ToReplace, 0, strpos($ToReplace, $Tag_End) - 1);
        $RepArray = explode(",", $ToReplace);
        // catch value from Tag-Begin to Tag-End from the Line and set the Tag-Variables $1 - $x
        $VarArray = explode(",", $Tag_Vars);
        for ($i = 0; $i < count($VarArray); $i++) {
            $var = trim($VarArray[$i]);
            $rep = trim($RepArray[$i]);
            $sTo = str_replace($var, $rep, $sTo);
        }
        // check for further Tags in Temp-Variable
        if (strpos($PartTwo, $Tag_Start) !== false) {
            $PartTwo = $this->_tag_value_replace($sFrom, $oldval, $PartTwo);
        }

        // put the output-line together
        return "$PartOne$sTo$PartTwo";
    }


    // ----------------------------------------------------------------------
    // PUBLIC FUNCTONS
    // ----------------------------------------------------------------------


    /**
     * add a tag for replacement
     * @param string   $sTag      Keyword for replacement
     * @param string   $sReplace  Text to replace
     * @return boolean
     */
    public function addTag(string $sTag, string $sReplace): bool
    {
        $this->_aTags[] = [
            "tag" => trim($sTag),
            "replace" => trim($sReplace)
        ];
        return true;
    }

    /**
     * read the taglist, parse it and create a tag array
     * @param  string  $sTagfile  optional: filename of a custom tagfile
     * @return boolean
     */
    public function readTagfile(string $sTagfile = ''): bool
    {
        $sTag = '';
        $sReplace = '';

        if ($sTagfile) {
            if (!file_exists($sTagfile)) {
                die('ERROR: ' . __METHOD__ . ' - file does not exist: [' . $sTagfile . ']');
            }
            $this->sTagfile = $sTagfile;
        }

        // require_once($_SERVER["DOCUMENT_ROOT"]."/axel/php/classes/cache.class.php");
        // $myCache=new AhCache("class-".__CLASS__, $this->sTagfile);  
        // $this->_aTags=$myCache->read();
        // if (!$this->_aTags || !count($this->_aTags)<1 || $myCache->isNewerThanFile($this->sTagfile)<0 || true) {  

        if (!file_exists($this->sTagfile)) {
            echo "Warning: " . $this->sTagfile . "does not exist.<br>";
            return false;
        }
        $aData = file($this->sTagfile);
        $ArrayCount = count($aData);
        $j = -1;
        $i = 0;
        while ($ArrayCount > 0) {
            // $line = trim($aData[$i]);
            $line = $aData[$i];
            if (strlen($line) < 2 || $line[0] == ";") {
                $i++;
                $ArrayCount--;
                continue;
            }
            if (stristr($line, ':=')) {
                $j++;
                if ($sTag) {
                    $this->addTag($sTag, $sReplace);
                }

                $aTmp = preg_split('/:=/', $line);
                $sTag = trim($aTmp[0]);
                $sReplace = trim($aTmp[1]);
                // $this->_aTags[$j]["tag"] = trim($aTmp[0]);
                // $this->_aTags[$j]["replace"] = trim($aTmp[1]);
            } else {
                if ($j > -1) {
                    // $this->_aTags[$j]["replace"] = $this->_aTags[$j]["replace"] . ' ' . $line;
                    $sReplace .= ' ' . $line;
                }
            }
            $i++;
            $ArrayCount--;
        }
        if ($sTag) {
            $this->addTag($sTag, $sReplace);
        }

        // $myCache->write($this->_aTags);

        // } // else echo "using cache.";

        return true;
    }


    /**
     * Show all defined tags
     * @return void
     */
    public function dump(): void
    {
        echo '<pre>' . htmlentities(print_r($this->_aTags, 1)) . '</pre>';
    }

    /**
     * Return all defined tags
     * @return array
     */
    public function getTags(): array
    {
        return $this->_aTags;
    }

    /**
     * Replace the tags in a given text according to the tags-array
     *
     * @param  string   $line      the text we want to process
     * @param  integer  $iRuns     optional: repeats; default: 1 run
     * @return string the processed line of text
     */
    public function doReplace(string $line, int $iRuns = 1): string
    {

        // make changes
        for ($j = 0; $j < count($this->_aTags); $j++) {
            // echo $j."<br>"; var_dump($this->_aTags[$j]);
            if (strpos($this->_aTags[$j]["tag"], '"') < 1) {
                if (strpos($line, $this->_aTags[$j]["tag"]) === false) {
                    // echo "not found.<br>";
                    continue;
                }
                if ($this->_aTags[$j]["replace"] === false) {
                    $line = str_replace($this->_aTags[$j]["tag"], '', $line);
                } else {
                    // echo "replace.<br>";
                    $line = str_replace($this->_aTags[$j]["tag"], $this->_aTags[$j]["replace"], $line);
                }
            } else {
                // echo "replace mit variable.<br>";
                $line = $this->_tag_value_replace($this->_aTags[$j]["tag"], $this->_aTags[$j]["replace"], $line);
            }
        }
        if ($iRuns > 1) {
            $iRuns--;
            $line = $this->doReplace($line, $iRuns);
        }

        // echo "return ";var_dump($line);
        return $line;
    }

}

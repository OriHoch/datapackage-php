<?php namespace frictionlessdata\datapackage;


class DataStream implements \Iterator
{
    protected $_currentLineNumber = 0;
    protected $_fopenResource;
    protected $_dataSource;

    public function __construct($dataSource)
    {
        try {
            $this->_fopenResource = fopen($dataSource, "r");
        } catch (\Exception $e) {
            throw new DataStreamOpenException("Failed to open source ".json_encode($dataSource));
        }
    }

    public function __destruct()
    {
        fclose($this->_fopenResource);
    }

    public function rewind() {
        if ($this->_currentLineNumber != 0) {
            throw new \Exception("DataStream does not support rewind, sorry");
        }
    }

    public function current() {
        $line = fgets($this->_fopenResource);
        if ($line === false) {
            return "";
        } else {
            return $line;
        }
    }

    public function key() {
        return $this->_currentLineNumber;
    }

    public function next() {
        $this->_currentLineNumber++;
    }

    public function valid() {
        return (!feof($this->_fopenResource));
    }
}


class DataStreamOpenException extends \Exception {};

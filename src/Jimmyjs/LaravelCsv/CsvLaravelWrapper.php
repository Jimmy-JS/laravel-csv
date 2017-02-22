<?php

namespace Jimmyjs\LaravelCsv;

use League\Csv\Reader;

class CsvLaravelWrapper
{
	private $csv;
	private $delimiter = ',';
	private $forceConvertUTF16;

	public function __construct($forceConvertUTF16 = true)
	{
		if (!ini_get("auto_detect_line_endings")) {
		    ini_set("auto_detect_line_endings", '1');
		}

		$this->forceConvertUTF16 = $forceConvertUTF16;
	}

	public function load($filePath)
	{
	    $csv = Reader::createFromPath($filePath)
	    			 ->setDelimiter($this->delimiter)
	    			 ->appendStreamFilter('convert.iconv.Windows-1252/UTF-8');

	    if ($this->forceConvertUTF16) {
	        $inputBom = $csv->getInputBOM();

	        if ($inputBom === Reader::BOM_UTF16_LE || $inputBom === Reader::BOM_UTF16_BE) {
	            $csv->appendStreamFilter('convert.iconv.UTF-16/UTF-8');
	        }
	    }

        $this->csv = $csv;

	    return $this;
	}

	public function first()
	{
		return $this->csv->fetchOne();
	}

	public function get()
	{
		return $this->csv->fetchAll();
	}

	public function all()
	{
		return $this->csv->fetchAll();
	}

	public function chunk($count, callable $callback)
	{
		$results = $this->forPage($page = 1, $count)->get();

		while (count($results) > 0) {
		    if (call_user_func($callback, $results) === false) {
		        return false;
		    }

		    $page++;

		    $results = $this->forPage($page, $count)->get();
		}

		return true;
	}

	public function forPage($page, $perPage = 15)
	{
	    return $this->skip(($page - 1) * $perPage)->take($perPage);
	}

	public function take($limit)
	{
		$this->csv->setLimit($limit);

		return $this;
	}

	public function skip($skip)
	{
		$this->csv->setOffset($skip);

		return $this;
	}

	public function getCsvInstance()
	{
		return $this->csv;
	}

	public function setDelimiter($delimiter)
	{
		if (empty($this->csv)) {
			$this->delimiter = $delimiter;
		} else {
			$this->csv->setDelimiter($delimiter);
		}

		return $this;
	}
}
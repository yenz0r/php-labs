<?php

$dataFile = "data.txt";

class EmailEdittor 
{
    private $patternForReplace = "/\\b\\w(\\w*[-.]?\\w+)+(?!@bsuir\\.by)@(\\w+\\.?\w+)+\\.[a-z]{2,5}\\b/";
    private $patternForMatch = "/\\b\\w(\\w*[-.]?\\w+)+@(\\w+\\.?\w+)+\\.[a-z]{2,5}\\b/";
    private $replaceStatment = "#email#";

    public function checkEmail($inputLine)
    {
        return (preg_match($this->patternForMatch, $inputLine) == 1) ? true : false; 
    }

    public function hideSpam($inputText) 
    {
        return preg_replace($this->patternForReplace, $this->replaceStatment, $inputText);
    }
}
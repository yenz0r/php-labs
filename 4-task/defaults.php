<?php

$dataFile = "data.txt";
$separateFileCharacter = "\n";
$separateInfoCharacter = "|";

class EmailEdittor 
{
    private $patternForReplace = "/\\b\\w(\\w*[-.]?\\w+)+(?!@bsuir\\.by)@(\\w+\\.?\w+)+\\.[a-z]{2,5}\\b/ui";
    private $patternForMatch = "/\\b\\w(\\w*[-.]?\\w+)+@(\\w+\\.?\w+)+\\.[a-z]{2,5}\\b/ui";
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

class UserChecker 
{
    private $patternForNameMatch = "/\\b([a-zA-Z]{2,}|[а-яёА-ЯЁ]{2,})\\b/ui";

    public function checkUserName($inputName) 
    {
        return (preg_match($this->patternForNameMatch, $inputName) == 1) ? true : false; 
    }
}
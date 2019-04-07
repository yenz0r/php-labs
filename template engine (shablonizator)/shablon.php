<?php
    class Content
    {
        var $properties = array();
        var $content;
        var $vars = [];

        public function set($name, $value) 
        {
            $this->properties[$name] = $value;
        }

        public function out_content($tpl) 
        {
            include_once("config.php");

            $this->content = file_get_contents($tpl);

            for ($i = 0; $i < 100; $i++) 
            {
                $vars["var" . $i] = mt_rand(0, 100);
            }

            function deleteBrackets($inputLine)
            {
                $resultLine = "";
                for ($i = 1; $i < strlen($inputLine)-1; $i++) {
                    $resultLine .= $inputLine[$i];
                }
                return $resultLine;
            }
        
            function makeStartString($key, $value) 
            {
                return "{" . $key . "=" . $value . "}";
            }
        
            $pattern = "/\\{\\w+[=][\\w.]+\\}/ui";
            preg_match_all($pattern, $this->content, $matches);
        
            $inputParams = [];
            foreach ($matches[0] as $line) {
                $tmp = explode("=", deleteBrackets($line));
                $inputParams[$tmp[0]] = $tmp[1];
            }

            foreach ($inputParams as $key=>$value) 
            {
                switch ($key) {
                    case 'FILE':
                        $dataFromFile = file_get_contents($value);
                        $this->content = str_replace(makeStartString($key, $value), $dataFromFile, $this->content);
                        break;
                    case 'CONFIG':
                        $this->content = str_replace(makeStartString($key, $value), $$value, $this->content);
                        break;
                    case 'VAR':
                        $this->content = str_replace(makeStartString($key, $value), $vars[$value], $this->content);
                        break;
                    default:
                        echo '!!!';
                        break;
                }
            }

            echo $this->content;
        }
    }

    $content = new Content();

?>
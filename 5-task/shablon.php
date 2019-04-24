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
            include_once('const.php');

            $this->content = file_get_contents($tpl);

            function deleteBrackets($inputLine)
            {
                $resultLine = "";
                for ($i = 1; $i < strlen($inputLine)-1; $i++) {
                    $resultLine .= $inputLine[$i];
                }
                return $resultLine;
            }
        
            $pattern = "/\\{DB=[\\w.]+\\}/ui";
            preg_match_all($pattern, $this->content, $matches);
        
            $inputParams = [];
            foreach ($matches[0] as $line) {
                $tmp = explode("=", deleteBrackets($line));
                array_push($inputParams, $tmp[1]);
            }

            $mysqli = new mysqli(HOST, USER, PASS, DB);
            
            if ($mysqli->connect_errno) {
                printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                exit();
            }
            
            foreach ($inputParams as $value) 
            {
                if ($result = $mysqli->query("select value from `dataForShablon` where prop='".$value."'")) {
                    while ($row = $result->fetch_assoc()) {
                        $this->content = str_replace("{DB=".$value."}", $row['value'], $this->content);
                    }
                    $result->free();
                }
            }
            $mysqli->close();

            echo $this->content;
        }
    }

    $content = new Content();

?>
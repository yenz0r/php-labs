<?php
    include_once('shablon.php');

    $content->set("{page_title}", "Site");
    $content->set("{page_text}", "Hello world!");

    $content->out_content("shablon.tpl");
?>
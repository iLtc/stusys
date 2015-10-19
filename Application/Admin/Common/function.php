<?php
function simpleHtmlEn($html){
    $content = htmlspecialchars_decode($html);
    $content = '<p>'.$content.'</p>';
    return str_replace("\r\n", '</p><p>', $content);
}

function simpleHtmlDe($html){
    $content = str_replace('</p><p>', "\n", $html);
    $content = str_replace('<p>', '', $content);
    return str_replace('</p>', '', $content);
}
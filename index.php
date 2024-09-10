<?php
//echo $_SERVER['REMOTE_ADDR'].'<br>'; 
if($_SERVER['REMOTE_ADDR'] === '177.57.196.48' || $_SERVER['REMOTE_ADDR'] == '177.57.196.48'){
     echo 'Hello World!';
}else{
    require 'index.html';
} 
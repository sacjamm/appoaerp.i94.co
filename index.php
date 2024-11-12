<?php
//echo $_SERVER['REMOTE_ADDR'].'<br>'; die;
if($_SERVER['REMOTE_ADDR'] === '189.94.20.115' || $_SERVER['REMOTE_ADDR'] == '189.94.20.115'){
     header('location: /public');
}else{
    require 'index.html';
} 
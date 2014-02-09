<?php

$config_txt = file_get_contents(getcwd() . '/config.txt');
$config_array = explode("\n", $config_txt);
$aws_key_line = explode(",", $config_array[0]);
$aws_key = $aws_key_line[1];
$aws_secret_key_line = explode(",", $config_array[1]);
$aws_secret_key = $aws_secret_key_line[1];
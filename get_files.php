<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require 'lib/aws.phar';
require 'utils/AWSutils.php';

$client = Aws\S3\S3Client::factory(array(
    // key vars set in AWSutils
    'key' => $aws_key,
    'secret' => $aws_secret_key
));

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => 'FileHotel'
));
$user_messages = file_get_contents("./messages.csv");
$msg_lines = explode("\n", $user_messages);
$msg_array = array();
foreach ($msg_lines as $line) {
    $tmp = explode(",", $line);
    // msg_array[unique_id] = message
    $msg_array[$tmp[0]] = $tmp[1];
}

$color_class = array("class=\"red\"","class=\"yellow\"","class=\"blue\"");
$ind = 0;
foreach ($iterator as $object) {
    $tmp = explode(".", $object['Key']);
    $unique_id = $tmp[0];
    $file_name = $tmp[1];

    echo "<p " . $color_class[$ind] . ">"
        . $file_name . ", " . $msg_array[$unique_id] . "</p>";
    $ind++;
    if ($ind == count($color_class)){
        $ind = 0;
    }
}
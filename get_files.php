<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include 'lib/aws.phar';

// get AWS keys

$config_txt = file_get_contents(getcwd() . '/config.txt');
$config_array = explode("\n", $config_txt);
$aws_key = explode(",", $config_array[0]);
$aws_key = $aws_key[1];
$aws_secret_key = explode(",", $config_array[1]);
$aws_secret_key = $aws_secret_key[1];

$client = Aws\S3\S3Client::factory(array(
    'key' => $aws_key,
    'secret' => $aws_secret_key
));

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => 'FileHotel'
));
echo "<p>";
foreach ($iterator as $object) {
    echo $object['Key'] . " ";
}
echo "</p>";

echo "<p>Done</p>";
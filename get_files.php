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

echo "<p>";
foreach ($iterator as $object) {
    echo $object['Key'] . " ";
}
echo "</p>";

echo "<p>Done</p>";
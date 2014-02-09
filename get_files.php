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

$color_class = array("class=\"red\"","class=\"yellow\"","class=\"blue\"");
$ind = 0;
foreach ($iterator as $object) {
    echo "<p " . $color_class[$ind] . ">" . $object['Key'] . "</p>";
    $ind++;
    if ($ind == count($color_class)){
        $ind = 0;
    }
}
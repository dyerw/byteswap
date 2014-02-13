<?php
date_default_timezone_set("UTC");
include 'lib/aws.phar';
include 'utils/AWSutils.php';

$client = Aws\S3\S3Client::factory(array(
    // key vars set in AWSutils
    'key' => $aws_key,
    'secret' => $aws_secret_key
));

/*
 * This downloads a file randomly from the S3 bucket
 * TODO: this should probably be separate from the upload
 */

// get an iterator for all the objects in the bucket
$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => 'FileHotel'
));

// put items in a list by index
$keys_list = array();
foreach ($iterator as $object){
    $keys_list[] = $object['Key'];
}

$rand_index = rand(0, count($keys_list) - 1);
$key = $keys_list[$rand_index];

$signedUrl = $client->getObjectUrl('FileHotel', $key, '+1 minutes');
// get content type
$head_array = $client->headObject(array(
    'Bucket' => 'FileHotel',
    'Key' => $key
));
$download_type = $head_array['ContentType'];



//Download a file for the user
header("Content-Transfer-Encoding: Binary");
$real_file_name =  explode(".", $key); //strip the unique id
header("Content-Type: ".$download_type);
header("Content-disposition: attachment; filename=\"" . $real_file_name[1] . "\"");
ob_clean();
flush();
readfile($signedUrl);

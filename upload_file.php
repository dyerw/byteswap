<?php
error_reporting(-1);
ini_set('display_errors', 'On');
// date is required for signed url
date_default_timezone_set("UTC");
include 'lib/aws.phar';
include 'utils/AWSutils.php';

$client = Aws\S3\S3Client::factory(array(
    // key vars set in AWSutils
    'key' => $aws_key,
    'secret' => $aws_secret_key
));

// gets the files size in MB
$file_size = $_FILES["upload_file"]["size"] / 1024 /1024;

// check if there were errors during upload
if ($_FILES['upload_file']['error'] > 0) {
    echo "ERROR: " . $_FILES['upload_file']['error'] . "<br>";

// check if the file is larger than 1MB
} else if ($file_size > 1) {
    echo $file_size . "MB is too big, please try a smaller file.";

// store file, give the user a new file
} else {
    //Upload the file to the directory
    $file_name = $_FILES['upload_file']['name'];
    $file_type = $_FILES['upload_file']['type'];
    $tmp_file_path = $_FILES['upload_file']['tmp_name'];
    $new_name = uniqid(rand(), true); // Currently not renaming files

    //Put file into S3 bucket
    $client->putObject(array(
        'Bucket' => 'FileHotel',
        // TODO: prepend unique id to key to prevent overwrites
        'Key' => $file_name,
        'SourceFile' => $tmp_file_path
    ));

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

    $signedUrl = $client->getObjectUrl('FileHotel', $key, '+10 minutes');

    echo $signedUrl;

    //Download a file for the user
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $key . "\"");
    ob_clean();
    flush();
    readfile($signedUrl);

}
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
//gets the message the user uploaded with the file
$usr_msg = $_POST["upload_msg"];

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
    $unique_id = uniqid();

    //Put file into S3 bucket
    $client->putObject(array(
        'Bucket' => 'FileHotel',
        'Key' => $unique_id.".".$file_name,
        'SourceFile' => $tmp_file_path,
        'ContentType' => $file_type
    ));

    //Store the user message in the csv file
    file_put_contents("./messages.csv", "\n".$unique_id.",".$usr_msg, $flag=FILE_APPEND);


    header('Location: http://liamdyer.com/uploadsite/download_page.html');
    exit();

}

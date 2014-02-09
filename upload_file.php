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


// finds the directory where uploaded files go
$uploads_dir = getcwd() . "/uploaded_files/";
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
    $new_name = uniqid(rand(), true);
    $new_file_path = $uploads_dir . $file_name;

    //move_uploaded_file($tmp_file_path, $new_file_path);
    $client->putObject(array(
        'Bucket' => 'FileHotel',
        'Key' => $file_name,
        'SourceFile' => $tmp_file_path
    ));

    //This all does nothing right now
    /*
    echo "Upload: " . $file_name . "<br>";
    echo "Type: " . $file_type . "<br>";
    echo "Tmp stored in: " . $tmp_file_path . "<br>";
    echo "Moved to: " . $new_file_path . "<br>"; */

    //Find a random file in the directory
    $dir_files = scandir($uploads_dir);
    //Check to make sure the directory was scanned correctly
    if (!$dir_files) {
        echo "DIRECTORY NOT SCANNED ABORT!!!<br>";
    }
    $rand_index = rand(2, count($dir_files) - 1);
    $download_file = $dir_files[$rand_index];
    $download_file_url = $uploads_dir . $download_file;

    //Download a file for the user
    header("Content-Type: " . $file_type);
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($download_file_url) . "\"");
    ob_clean();
    flush();
    readfile($download_file_url);
}

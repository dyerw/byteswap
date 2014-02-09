<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script language="javascript" type="text/javascript" src="upload_verifier.js"></script>
</head>
<body>
    <div id="main">
        <p>
            Files are capped at 1MB for now. Thanks for trying this out.
            Currently in transition and acting wooooonky.
        </p>
        <p>
            Here's what to do: 1. upload a file 2. get a random file someone else uploaded
        </p>
        <p>
        <?php
            $uploads_dir = getcwd() . "/uploaded_files/";
            $count = count(scandir($uploads_dir)) - 2;
            echo $count;
        ?> files on the server right now
        </p>
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="upload_file" id="upload_field"><br>
            <input type="submit" name="submit" value="Upload File">
        </form>
        <button onclick="loadBucketContents()">What's in the file hotel?</button>
    </div>
    <div id="file_list"></div>
</body>
</html>
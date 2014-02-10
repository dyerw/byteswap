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
        </p>
        <p>
            Here's what to do: 1. upload a file 2. get a random file someone else uploaded
        </p>
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="upload_file" id="upload_field"><br>
            <label for="msg_field">What is this?</label>
            <input type="text" name="upload_msg" id="msg_field"><br>
            <input type="submit" name="submit" value="Upload File">
        </form>
        <button onclick="loadBucketContents()">What's in the file hotel?</button>
    </div>
    <div id="file_list"></div>
</body>
</html>
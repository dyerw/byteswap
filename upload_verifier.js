loadBucketContents = function(){
    //make an ajax request
     var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("file_list").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", "get_files.php", true)
    xmlhttp.send()
}

validateForm = function() {
    var msg = document.forms["upload_form"]["upload_msg"].value;
    var upload_file = document.getElementById("upload_field");
    if (!upload_file.files[0]) {
        alert ("please select a file");
        return false;
    }
   // check if greater than 1MB
   if (upload_file.files[0].size > 1000000) {
       alert ("file is larger than 1MB, please choose smaller file")
       return false;
   }

    if (msg == null || msg == "") {
        alert("you need to enter a description for your file");
        return false;
    }
    return true;
}
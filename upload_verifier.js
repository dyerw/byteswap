loadBucketContents = function(){
    //make an ajax request
    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("file_list").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp = open("GET", "get_files.php", true)
    xmlhttp.send()
}
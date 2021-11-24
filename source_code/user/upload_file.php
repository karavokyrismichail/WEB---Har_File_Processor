<!DOCTYPE html>
<html>
    <head>
        <title>Upload file</title>
        <link rel="stylesheet" type="text/css" href="upload_file.css">
</head>
<body>
    <form class="upload-file" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file" />
        <input type="button" value="Upload" id="btn_uploadfile" onclick="uploadFile();"> 
    </form>
        
    <div class = "buttons">
    <button class="w3-button w3-light-grey w3-padding-large w3-section" onclick="uptoBase();">
            <i class="fa fa-database"></i> Store file
            </button>

            <button class="w3-button w3-light-grey w3-padding-large w3-section" onclick="download();">
            <i class="fa fa-download"></i> Download file
        </button>
    </div>

    <script type="text/javascript" src="upload_file.js"></script>
    <script src="jquery-3.6.0.js"></script>
</body>
</html>
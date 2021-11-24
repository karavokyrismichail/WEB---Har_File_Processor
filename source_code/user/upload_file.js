function uploadFile() {

   var files = document.getElementById("file").files;
   

   if(files.length > 0 ){

     var fr = new FileReader();
     //while i read the file i delete the sensitive data and send the updated to php
     fr.onload = function(e) { 
        console.log(e);
        //filtering file's data
        try {
           var result = JSON.parse(e.target.result);
       } catch (e) {
           if (e instanceof SyntaxError) {
               alert("There has been a problem with the har file. Please try another one.")
               //test comment
           }
       }  
        var length = result.log.entries.length;
        for(var i=0; i<length; i++)
        {
           delete result.log.entries[i].request.postData;
        }
        var formatted = JSON.stringify(result, null, 2);
        var data = formatted;
        // console.log(formatted);

        var xhttp = new XMLHttpRequest();
        var formData = new FormData();
        formData.append("file", files[0]);
        formData.append("data",data);

        // Set POST method and ajax file path
        xhttp.open("POST", "ajax_upload.php", true);
        // call on request changes state
        xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
           var response = this.responseText;
           if(response == 1){
              alert("Upload successfully.");
           }else{
              alert("File not uploaded.");
           }
           }
        };
        xhttp.send(formData);
     }  
     //triggering the read file in order to access the file
     fr.readAsText(files.item(0));
     
   }else{
      alert("Please select a file");
   }
}

function uptoBase(){
  $.ajax({
     type: "GET",
     url: "sendDatabase.php" ,
     data: {},
 });
  location.reload();
}

// main idea can be found here https://stackoverflow.com/a/18197341
// tried also with php/ajax and readfile+curl but downloaded in the server side so used plain js
function download(){
   $.get('getCurrentFile.php', function (file_name) {
      var element = document.createElement("a");
      element.setAttribute('download', file_name);
      element.href = file_name;
      document.body.appendChild(element);
      element.click();
      document.body.removeChild(element);
   });
   location.reload();
}

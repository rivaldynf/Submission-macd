<!DOCTYPE html>
<html>
<head>
    <title>Upload to BLOB</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<h1><center><u>Mengunggah file gambar ke Azure Blob</u></center></h1>
<form action="phpQS.php" method="post" enctype="multipart/form-data">
    Pilih file :
    <input type="file" accept="image/*" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload file" name="submit">
</form>
<script type="text/javascript">
        function processImage() {
            // **********************************************
            // *** Update or verify the following values. ***
            // **********************************************
     
            // Replace <Subscription Key> with your valid subscription key.
            var subscriptionKey = "07f65ac295e849f6ac7966b52af63c67";
     
            // You must use the same Azure region in your REST API method as you used to
            // get your subscription keys. For example, if you got your subscription keys
            // from the West US region, replace "westcentralus" in the URL
            // below with "westus".
            //
            // Free trial subscription keys are generated in the "westus" region.
            // If you use a free trial subscription key, you shouldn't need to change
            // this region.
            var uriBase =
                "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
     
            // Request parameters.
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };
     
            // Display the image.
            var sourceImageUrl = document.getElementById("inputImage").value;
            document.querySelector("#sourceImage").src = sourceImageUrl;
     
            // Make the REST API call.
            $.ajax({
                url: uriBase + "?" + $.param(params),
     
                // Request headers.
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },
     
                type: "POST",
     
                // Request body.
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })
     
            .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
            console.log(data.categories[0].name);
               console.log(data.description.captions[0]);
               console.log(data)
               desk1 = data.description.captions[0].text;
            desk = data.categories[0].name;
            document.getElementById("description").innerHTML = (desk1);
            })
     
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
        };
    </script>
     
    <br> <br> <br>
<h1><center><u>Analisis Gambar</u></center></h1>
Masukkan URL gambar, lalu klik tombol <strong>Analisis Gambar</strong> 
<br><br>
URL Gambar:
<input type="text" name="inputImage" id="inputImage"
    value="" />
<button onclick="processImage()">Analisis Gambar</button>
<br><br>
<div id="wrapper" style="width:1020px; display:table;">
    
    <div id="imageDiv" style="width:420px; display:table-cell;">
        Tampilan Gambar:
        <br><br>
        <img id="sourceImage" width="400" />
    <figcaption id="description"></figcaption>
</div>
</body>
</html>

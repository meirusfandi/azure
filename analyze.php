<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analyze Image Using Computer Vision </title>
    <script src="jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <!-- Source image process section -->
    <script type="text/javascript">
        function processImage(){
            var subscriptionKey = "2e2671970d6b469399ac05285a925f3e";
            var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            // Display the image.
            var sourceImageUrl = document.getElementById("imageurl").value;
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

    <?php 
        if (isset($_POST["analyze"])){
            $url = isset($_POST["inputImage"]);
        }
    ?>  

    <!-- Form Show response from Computer Vision -->
    <h2>Show Respon From Analyze | Computer Vision</h2>
    <div class="row">
        <div class="col-md-12">
            <?php echo $url ?>
            <input type="hidden" name="imageurl" value="<?php echo $url; ?>">
            <button onclick="processImage()" class="btn btn-primary">Analyze it!</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="wrapper" style="width:1020px; display:table;">
                <div id="jsonOutput" style="width:600px; display:table-cell;">
                    Response:
                    <br><br>
                    <textarea id="responseTextArea" class="UIInput"
                        style="width:580px; height:400px;"></textarea>
                </div>
                <div id="imageDiv" style="width:420px; display:table-cell;">
                    Source image:
                    <br><br>
                    <img id="sourceImage" width="400" />
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
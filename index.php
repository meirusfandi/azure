<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Final Submission | Azure Cloud Developer Academy</title>
    <script src="jquery.min.js" type="text/javascript"></script>
</head>
<body>
    <div class="row">
        <!-- Main Upload File Section -->
        <div>
            <h2>Upload Image</h2>
            <div class="form-group">
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <input type="submit" name="upload" value="Upload Image">
                </form>
            </div>
        </div>
        <hr>
        <!-- Main View All Files Section -->
        <div>
            <div>
                <h2>Image From Blob Storage</h2>
                <form action="index.php" method="post">
                    <input type="submit" name="loadImage" value="Refresh">
                </form>
                <table class="table-hover">
                    <!-- Head table section -->
                    <thead>
                        <th>No. </th>
                        <th>File Name</th>
                        <th>File URL</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </thead>
                    <!-- Body table section -->
                    <tbody>
                        <?php 
                            $i = 0;
                            do {
                                foreach ($result->listBlobs() as $blob){

                        ?>
                                    <tr>
                                        <td><?php echo ++$i; ?></td>
                                        <td><?php echo $blob->getName(); ?></td>
                                        <td><?php echo $blob->getUrl(); ?></td>
                                        <td width="200" height="200"><img src="<?php echo $blob->getUrl(); ?>" alt="<?php echo $blob->getName(); ?>"></td>
                                        <td>
                                        <input type="hidden" name="imageUrl" id="imageUrl"
                                            value="<?php echo $blob->getUrl(); ?>"/>
                                        <button onclick="processImage()">Analyze image</button>
                                        </td>
                                    </tr>
                        <?php
                                } $listblob->setContinuationToken($result->getContinuationToken());
                            } while ($result->getContinuationToken());

                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <!-- Main View Analyze Image Section -->
        <div>
            <!-- Form Show response from Computer Vision -->
            <h2>Show Respon From Analyze | Computer Vision</h2>
            <div class="col-md-12">
                <?php echo "The image URL is".$url; ?><br>
                <input type="hidden" name="imageurl" value="<?php echo $url; ?>"><br>
                <button onclick="processImage()" class="btn btn-primary">Analyze it!</button>
            </div>
        
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
    </div>

    <?php 
        require_once 'vendor/autoload.php';

        //import Microsoft Azure Storage 
        use MicrosoftAzure\Storage\Blob\BlobRestProxy;
        use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
        use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
        use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
        use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

        $connect = "DefaultEndpointsProtocol=https;AccountName=meirusfandiwev;AccountKey=vwhIwbU1kaFKEZMFWTd5ng21ux0PA8P8XRgUgo6atp8xbKPYFStk5vz+7/lTIG8SyZ/37LGfYqQxqbsX/EIwCQ==;EndpointSuffix=core.windows.net";
        $container = "meirusfandi";
        $blobs = BlobRestProxy::createBlobService($connect);

        if (isset($_POST['upload'])){
            try {
                $file = strtolower($_FILES['file']['name']);
                $content = fopen($_FILES['file']['tmp_name'], "r");

                // upload blob
                $blobs->createBlockBlob($container, $file, $content);
                echo "Upload Success";
            }catch(ServiceException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }catch(InvalidArgumentTypeException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }
        } else if (isset($_POST['loadImage'])){
            $listblob = new ListBlobsOptions();
            $listblob->setPrefix("");
            $result = $blobs->listBlobs($container, $listblob);
        }
    ?>

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
            var sourceImageUrl = document.getElementById("imageUrl").value;
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
</body>
</html>
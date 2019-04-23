<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Azure Academy | Menjadi Azure Cloud Developer</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>

    <!-- PHP handling section -->
    <?php 

        //include vendor folder and random_string file
        require_once 'vendor/autoload.php';
        require_once 'random_string.php';

        //import Microsoft Azure Storage 
        use MicrosoftAzure\Storage\Blob\BlobRestProxy;
        use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
        use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
        use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
        use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

        //create connection string
        $connect = "DefaultEndpointsProtocol=https;AccountName=meirusfandiwev;AccountKey=vwhIwbU1kaFKEZMFWTd5ng21ux0PA8P8XRgUgo6atp8xbKPYFStk5vz+7/lTIG8SyZ/37LGfYqQxqbsX/EIwCQ==;EndpointSuffix=core.windows.net";

        //create container name
        $containername = "fansdev".generateRandomString();

        // Create blob client.
        $blobclient = BlobRestProxy::createBlobService($connect);

        $containeroptions = new CreateContainerOptions();
        $containeroptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

        // Menetapkan metadata dari container.
        $containeroptions->addMetaData("key1", "value1");
        $containeroptions->addMetaData("key2", "value2");

        //create container to storage
        $blobclient->createContainer($containername, $containeroptions);

        if (isset($_POST['upload'])){
            $filename = strtolower($_FILES['image']['name']);
            $contentfile = fopen($_FILES['image']['tmp_name'], 'r');

            //upload blob file
            $blobclient->createBlockBlob($containername, $filename, $contentfile);

            //redirect using header
            header("Location : index.php");
        } else if (isset($_POST['analyze'])){
            if (isset($_POST['imageurl'])){
                $imageurl = $_POST['imageurl'];
            }
        }

        //get blob list from blob storage
        $listblob = new ListBlobsOptions();
        $listblob->setPrefix("fansdev");
    ?>

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

        function uploadImage(){
            
        };
    </script>

    <!-- Form upload image section -->
    <h2>Form Upload File Image | Azure Blob Storage</h2>
    <div class="row">
        <div class="col-md-12">
            <label for="uploadlabel">Upload Image</label>
            <form action="index.php" enctype="multipart/form-data" method="post">
                <input type="file" name="image">
                <input type="submit" name="upload" value="Upload Image" class="btn btn-primary" onclick="uploadImage()">
            </form>
        </div>
    </div>

    <hr>
    <!-- Form show image from blob storage section -->
    <h2>List Uploaded Data | Azure Blob Storage</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>Nama File</th>
                        <th>Link Url Image</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $i = 1;
                        do {
                            $result = $blobclient->listBlobs($containername, $listblob);
                            foreach ($result->getBlobs() as $blobfile){
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $blobfile->getName();?></td>
                                <td><?php echo $blobfile->getUrl();?></td>
                                <td width="100" height="100"><img src="<?php echo $blobfile->getUrl(); ?>" alt=""></td>
                                <td>
                                    <input type="hidden" id="imageurl" name="imageurl" value="<?php echo $blobfile->getUrl(); ?>">
                                    <button onclick="processImage()">Analyze Image</button>
                                </td>
                            </tr>
                        <?php 
                            $i++;
                            }
                            $listblob->setContinuationToken($result->getContinuationToken());
                        } while($result->getContinuationToken());
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <hr>
    <!-- Form Show response from Computer Vision -->
    <h2>Show Respon From Analyze | Computer Vision</h2>
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
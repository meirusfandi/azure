<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Image Using Azure Blob Storage</title>
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
            try{
                $filename = strtolower($_FILES['image']['name']);
                $contentfile = fopen($_FILES['image']['tmp_name'], 'r');

                //upload blob file
                $blobclient->createBlockBlob($containername, $filename, $contentfile);
                // get list blobs
                $bloblists = new ListBlobsOptions();
                $bloblists->setPrefix("meirusfandi");

                $urlImage = "https://meirusfandiwev.blob.core.windows.net/".$containername."/".$filename;

                echo "These image from upload: ";
                echo "<br/>";
                echo "The url image is : https://meirusfandiwev.blob.core.windows.net/".$containername."/".$filename;
                echo "<br/>";
                echo '<img src="'.$urlImage.'" width="200" height="200"/>';

                do{
                    $result = $blob_client->listBlobs($containername, $bloblists);
                    foreach ($result->getBlobs() as $blob)
                    {

                        echo '<img src="'.$blob->getUrl().'" width="400" height="400"/>';
                
                    }
                    $bloblists->setContinuationToken($result->getContinuationToken());
                } while($result->getContinuationToken());
                
                ?>

                <form action="analyze.php" method="post">
                    <input type="text" name="inputImage" id="inputImage" width="400" value="<?php echo  $urlImage;?>" />
                    <input type="submit" name="analyze" id="analyze" value="Analyze it">
                </form>
                
                <?php 
                $blob = $blob_client->getBlob($containername, $name);
                fpassthru($blob->getContentStream());
            }catch(ServiceException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }catch(InvalidArgumentTypeException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }

        }
    ?>
</body>
</html>
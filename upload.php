<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Image Using Azure Blob Storage</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <!-- PHP handling section -->
    <?php 

        //include vendor folder and random_string file
        require_once 'vendor/autoload.php';

        //import Microsoft Azure Storage 
        use MicrosoftAzure\Storage\Blob\BlobRestProxy;
        use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
        use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
        use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
        use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

        //create connection string
        $connect = "DefaultEndpointsProtocol=https;AccountName=meirusfandiwev;AccountKey=vwhIwbU1kaFKEZMFWTd5ng21ux0PA8P8XRgUgo6atp8xbKPYFStk5vz+7/lTIG8SyZ/37LGfYqQxqbsX/EIwCQ==;EndpointSuffix=core.windows.net";

        //create container name
        $containername = "fansdev";

        // Create blob client.
        $blobclient = BlobRestProxy::createBlobService($connect);

        // $containeroptions = new CreateContainerOptions();
        // $containeroptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

        // // Menetapkan metadata dari container.
        // $containeroptions->addMetaData("key1", "value1");
        // $containeroptions->addMetaData("key2", "value2");

        //create container to storage
        // $blobclient->createContainer($containername, $containeroptions);

        if (isset($_POST['upload'])){
            try{
                $filename = strtolower($_FILES['image']['name']);
                $contentfile = fopen($_FILES['image']['tmp_name'], 'r');

                //upload blob file
                $blobclient->createBlockBlob($containername, $filename, $contentfile);
                // get list blobs
                $bloblists = new ListBlobsOptions();
                $bloblists->setPrefix("");

                $urlImage = "https://meirusfandiwev.blob.core.windows.net/".$containername."/".$filename;

                echo "<br/>";
                echo "The url image is : https://meirusfandiwev.blob.core.windows.net/".$containername."/".$filename;
                echo "<br/>";
                echo '<img src="'.$urlImage.'" width="400" height="400"/>';

                echo $urlImage." hmmm<br>";

                do{
                    $result = $blobclient->listBlobs($containername, $bloblists);
                    echo "sampe kesini ?";
                    echo "nilai result";
                    foreach ($result->getBlobs() as $blob)
                    {
                        echo "apakah disini ?";
                        echo '<img src="'.$blob->getUrl().'" width="400" height="400"/>';
                
                    }
                    $bloblists->setContinuationToken($result->getContinuationToken());
                } while($result->getContinuationToken());
                
                $blob = $blobclient->getBlob($containername, $filename);
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
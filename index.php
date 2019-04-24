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

</body>
</html>
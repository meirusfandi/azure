<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Data Page - Submission Azure 1</title>
</head>
<body>
    <h1>Tambah Data baru</h1>
    <hr>
    <a href="index.php">Back</a>
    <form action="add_action.php" method="post">
        <div class="row">
            <label for="username">Username</label>
            <input type="text" name="username">
        </div>

        <div class="row">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname">
        </div>

        <div class="row">
            <label for="job">Job Title</label>
            <input type="text" name="jobtitle">
        </div>

        <input type="submit" value="Save">
    </form>
</body>
</html>
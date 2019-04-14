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
    <form action="add.php" method="post">
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

    <?php 
        include 'connect.php';
        if (isset($_POST['submit'])){
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $job = $_POST['job'];
                // Insert data
                $sql_insert = "INSERT INTO user (name, email, job) 
                            VALUES (?,?,?)";
                $stmt = $connect->prepare($sql_insert);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $username);
                $stmt->bindValue(3, $job);
                $stmt->execute();
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
            echo "<h3>Your're registered!</h3>";
        }
    ?>
</body>
</html>
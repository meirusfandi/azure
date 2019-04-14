<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Page - Submission Azure 1</title>
</head>
<body>
    <h1>List Data</h1>
    <hr>
    <a href="add.php">Tambah Data</a>
    <table>
        <thead>
            <tr>
                <th>No. </th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Job Title</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include 'connect.php';
                $no = 1;
                $selectquery = "SELECT * FROM user";
                $query = $connect->query($selectquery);
                $data = $query->fetchAll();

                if (count($data) == 0) { ?>
                    <tr colspan="6">No data on Database</tr>
                <?php } else if (count($data) > 0){ 
                    foreach($data as $value) {
                    ?>
                    <tr>
                        <td>$no++</td>
                        <td>$value['username']</td>
                        <td>$value['fullname']</td>
                        <td>$value['jobtitle']</td>
                        <td><a href="edit.php?username=<?php echo $value['username'] ?>">Edit</a></td>
                        <td><a href="delete.php?username=<?php echo value['username'] ?>">Delete</a></td>
                    </tr>
                    
                <?php }
                }
            ?>
            
            <?php ?>
        </tbody>
    </table>
</body>
</html>
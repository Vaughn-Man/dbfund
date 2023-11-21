<?php
session_start();
include('configure.php');
include('global.php');
$id = null;
$name = null;
$email = null;
$phone = null;
$title = null;
$created = null;

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM contacts WHERE `id`='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result);
    header("Location: index.php");
}


if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $title = $_GET['title'];
    $created = $_GET['created'];
    $id = $_GET['id'];
}

if (isset($_POST['name']) && !isset($id)) {
    //for add
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $created = $_POST['created'];
    $sql = "INSERT INTO contacts (name, email, phone, title, created) VALUES ('$name', '$email', '$phone', '$title', '$created')";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result);
    //$conn->close();
}

if (isset($_POST['name']) && isset($id)) {
     //for update
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $created = $_POST['created'];
    $sql = "UPDATE contacts SET `name`='$name', `email`='$email', `phone`='$phone' , `title`='$title', `created`='$created'  WHERE `id`='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result);
}


?>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<form method="POST" action="">
    <p>Instructor Name <br><input name="name" value="<?= isset($name) ? $name : '' ?>"> </p>
    <p>Instructor Email <br><input name="email" value="<?= isset($email) ? $email : '' ?>"> </p>
    <p>Instructor Phone Number <br><input name="phone" value="<?= isset($phone) ? $phone : '' ?>"> </p>
    <p>Title <br><input name="title" value="<?= isset($title) ? $title : '' ?>"> </p>
    <p>Date Created <br><input type="datetime-local" name="created" value="<?= isset($created) ? $created : '' ?>"> </p>
    <br> <br>
    <?php if (isset($id)) { ?>
        <a href="index.php">Cancel</a>
        <button>Update</button>
    <?php } else { ?>
        <button>Save</button>
    <?php } ?>
</form>

List Of users

<div><center><table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Instructor Name</th>
            <th>Instructor Email</th>
            <th>Instructor Phone Number</th>
            <th>Title</th>
            <th>Date Created</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

    </thead>

    <tbody>

        <?php
        $sql = "SELECT * FROM contacts";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td width="200"> <a style="color: red" href="?action=delete&id=<?= $row['id'] ?>"> DELETE </a></td>
                    <td>    <a href="?action=edit&id=<?= $row['id'] ?>&name=<?= $row['name'] ?>&email=<?= $row['email'] ?>&phone=<?= $row['phone'] ?>&title=<?= $row['title'] ?>&created=<?= $row['created'] ?>"> EDIT </a></td>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>

</table></center></div>
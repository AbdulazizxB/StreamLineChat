<?php include 'pdo.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    return;
}

if (isset($_POST['message'])) {
    $sql = "INSERT INTO message (content, user_id) VALUES (:content, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
            ':content' => $_POST['message'],
            ':user_id' => $_SESSION['user_id']
        )
    );
    header('location: index.php');
    return;
}
$sql = "SELECT * FROM message ORDER BY id";
$stmt = $pdo->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Chat App</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row p-2 bg-color-green">
            <h2 class="col-12">Online Chat App</h2>
        </div>
        <div class="row p-2 bg-color-gray">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['user_id'] == $_SESSION['user_id']) {
                    ?>
                    <div class="col-12">
                        <div class="d-flex">
                            <div class="message my-message">
                                <b class="message-header">Me:</b>
                                <div>
                                    <?= $row['content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-12">
                        <div class="d-flex">
                            <div class="message others-message">
                                <b class="message-header">
                                    <?= $row['user_id'] ?>:
                                </b>
                                <div>
                                    <?= $row['content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <form class="row p-2 bg-color-green send-message" action="index.php" method="POST">
            <div class="col-9 col-md-10">
                <input type="text" name="message" class="form-control" placeholder="Write your message">
            </div>
            <div class="col-3 col-md-2">
                <button type="submit" class="btn btn-light form-control">Send</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add a Professor | Rate my Professor</title>
    <?php

    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
        //TODO:Some sort of message in login page telling them that they need to log in
        header('Location:login.php');
    }
    $userID = $_SESSION['user_id'];
    $deptGiven = array_key_exists('deptID', $_GET);
    if ($deptGiven) {
        $deptID = $_GET['deptID'];
        $query = "SELECT department.name AS deptName, college.id AS collegeID, college.name AS collegeName " .
            "FROM department JOIN college ON department.college_id=college.id WHERE department.id=$deptID;";
        $result = $db->query($query);
        $result = $result->fetch();
        $deptName = $result['deptName'];
        $collegeID = $result['collegeID'];
        $collegeName = $result['collegeName'];
    }
    ?>
</head>

<body>
<div class="jumbotron">
    <h3 align="center">Add new Professor</h3>
    <form class="form-horizontal" role="form" method="POST" action="add-professor-review.php">
        <?php
        if ($deptGiven) {
            printf("<input type='hidden' name='dept_id' value='$deptID'>");
        }
        ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">College:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="collegeName" <?php if ($deptGiven) {
                    echo "value='$collegeName' disabled";
                } ?> >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Department:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="deptName" <?php if ($deptGiven) {
                    echo "value='$deptName' disabled";
                } ?> >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Professor's Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="profName" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4" align="center">
                <input class="btn default" type="submit" value="Submit">
                <input class="btn btn-danger" type="reset" value="Reset">
            </div>

        </div>
    </form>
    <div class="container">


    </div> <!-- /container -->

</body>
</html>

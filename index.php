<?php
session_start();
require_once "function.php";
$info = '';
$task = $_GET['task'] ??'report';
$error = $_GET['error'] ??'0';

if ($task == 'edit') {
    if (!hasPrivilege()) {
        header('location:/index.php?task=report');
    }
}

if ($task == 'delete') {
    if (!isAdmin()) {
        header('location:/index.php?task=report');
        return;    
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Employee Information</h2>
                <?php
                include_once('nav.php'); 
                ?>

                <?php
                if ($info != '') {
                    echo '<p>'. $info .'</p>';
                } 
                ?>
            </div>
        </div>

        <?php
        if ($error == '1'): 
        ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <blockquote>Duplicate Employee ID</blockquote>
            </div>
        </div>
        <?php endif; ?>
        <?php
        if ($task == 'report'): 
        ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php generateReport() ?>
            </div>
        </div>
        <?php endif; ?>
    <?php if ( $task == 'add' ): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php?task=add" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
                    <label for="emid">Employee ID</label>
                    <input type="number" name="emid" id="emid" value="<?php echo $emid; ?>">
                    <button type="submit" class="button-primary" name="submit">Save</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if ( $task == 'edit'):
        $id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS );
        $employee = getEmployee( $id );
        if ( $employe ):
            ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form method="POST">
                        <input type="hidden" value="<?php echo $id ?>" name="id">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $employee['fname']; ?>">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $employee['lname']; ?>">
                        <label for="emid">Employee ID</label>
                        <input type="number" name="emid" id="emid" value="<?php echo $employee['emid']; ?>">
                        <button type="submit" class="button-primary" name="submit">Update</button>
                    </form>
                </div>
            </div>
        <?php
        endif;
    endif;
    ?>
</div>
<script type="text/javascript" src="assets/js/script.js"></script>
    </div>
</body>
</html>
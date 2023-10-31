<?php
define("DB_NAME", "path_to_your_db.txt");

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEditor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'editor';
}

function hasPrivilege(){
    return isAdmin() || isEditor();
}

function generateReport() {
    if (file_exists(DB_NAME)) {
        $serializedData = file_get_contents(DB_NAME);
        $employees = unserialize($serializedData);

        if (is_array($employees) && !empty($employees)) {
            ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <?php if (hasPrivilege()): ?>
                        <th width="25%">Action</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($employees as $employee) : ?>
                    <tr>
                        <td><?php echo sprintf('%s %s', $employee['fname'], $employee['lname']); ?></td>
                        <td><?php echo sprintf('%s', $employee['emid']); ?></td>
                        <?php if (isAdmin()): ?>
                            <td><?php echo sprintf('<a href="index.php?task=edit&id=%s">Edit</a> | <a class="delete" href="/crud/index.php?task=delete&id=%s">Delete</a>', $employee['id'], $employee['id']); ?></td>
                        <?php elseif (isEditor()): ?>
                            <td><?php echo sprintf('<a href="index.php?task=edit&id=%s">Edit</a>', $employee['id']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php
        } else {
            echo "No data found in the database.";
        }
    } else {
        echo "Database file not found.";
    }
}

function getEmployee($id) {
    if (file_exists(DB_NAME)) {
        $serializedData = file_get_contents(DB_NAME);
        $employees = unserialize($serializedData);

        if (is_array($employees) && !empty($employees)) {
            foreach ($employees as $employee) {
                if ($employee['id'] == $id) {
                    return $employee;
                }
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

    return false;
}
?>

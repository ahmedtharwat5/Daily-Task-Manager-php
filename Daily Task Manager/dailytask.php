<!DOCTYPE html>
<html>
<head>
    <title>Daily Task Manager</title>
</head>
<body>
    <h1>Daily Task Manager</h1>

    <h2>Add a Task</h2>
    <form action="" method="post">
        <input type="text" name="task" placeholder="Enter your task" required>
        <input type="submit" value="Add Task">
    </form>

    <?php
    // Initialize an empty tasks array
    $tasks = [];

    // Check if tasks are stored in a file
    if (file_exists('tasks.txt')) {
        // Read tasks from the file
        $tasks = file('tasks.txt', FILE_IGNORE_NEW_LINES);
    }

    // Add a new task
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
        $newTask = $_POST['task'];
        if (!empty($newTask)) {
            // Add the task to the array
            $tasks[] = $newTask;
            // Save tasks to the file
            file_put_contents('tasks.txt', implode("\n", $tasks));
        }
    }

    // Display the tasks
    if (!empty($tasks)) {
        echo "<h2>Tasks</h2>";
        echo "<ul>";
        foreach ($tasks as $task) {
            echo "<li>$task</li>";
        }
        echo "</ul>";
    }

    // Delete a task
    if (isset($_GET['delete'])) {
        $taskIndex = $_GET['delete'];
        if (isset($tasks[$taskIndex])) {
            unset($tasks[$taskIndex]);
            // Save the updated task list
            file_put_contents('tasks.txt', implode("\n", $tasks));
        }
    }
    ?>

    <?php
    if (!empty($tasks)) {
        echo "<h2>Delete a Task</h2>";
        echo "<ul>";
        foreach ($tasks as $index => $task) {
            echo "<li>$task - <a href='?delete=$index'>Delete</a></li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>

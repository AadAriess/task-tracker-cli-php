<?php

define('TASKS_FILE', 'tasks.json');

function loadTasks()
{
    if (!file_exists(TASKS_FILE)) {
        file_put_contents(TASKS_FILE, json_encode([]));
    }

    $content = file_get_contents(TASKS_FILE);
    $tasks = json_decode($content, true);

    // Jika gagal decode atau kosong, kembalikan array kosong
    if (!is_array($tasks)) {
        $tasks = [];
    }

    return $tasks;
}

function saveTasks($tasks)
{
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

function getNextId($tasks)
{
    $ids = array_column($tasks, 'id');
    return empty($ids) ? 1 : max($ids) + 1;
}

function now()
{
    return date('Y-m-d H:i:s');
}

function addTask($desc)
{
    $tasks = loadTasks();
    $id = getNextId($tasks);
    $task = [
        'id' => $id,
        'description' => $desc,
        'status' => 'todo',
        'createdAt' => now(),
        'updatedAt' => now(),
    ];
    $tasks[] = $task;
    saveTasks($tasks);
    echo "Task added successfully (ID: $id)\n";
}

function updateTask($id, $newDesc)
{
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['description'] = $newDesc;
            $task['updatedAt'] = now();
            saveTasks($tasks);
            echo "Task $id updated successfully.\n";
            return;
        }
    }
    echo "Task with ID $id not found.\n";
}

function deleteTask($id)
{
    $tasks = loadTasks();
    $filtered = array_filter($tasks, fn($t) => $t['id'] != $id);
    if (count($tasks) === count($filtered)) {
        echo "Task with ID $id not found.\n";
    } else {
        saveTasks(array_values($filtered));
        echo "Task $id deleted successfully.\n";
    }
}

function markStatus($id, $status)
{
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['status'] = $status;
            $task['updatedAt'] = now();
            saveTasks($tasks);
            echo "Task $id marked as $status.\n";
            return;
        }
    }
    echo "Task with ID $id not found.\n";
}

function listTasks($filter = null)
{
    $tasks = loadTasks();
    foreach ($tasks as $task) {
        if (!$filter || $task['status'] === $filter) {
            echo "[{$task['id']}] {$task['description']} - Status: {$task['status']} - Created At: {$task['createdAt']}\n";
        }
    }
}

// === Main Execution ===
$args = $argv;
array_shift($args); // Remove script name

if (count($args) === 0) {
    echo "No command provided.\n";
    exit;
}

$command = $args[0];

switch ($command) {
    case 'add':
        if (isset($args[1])) {
            addTask($args[1]);
        } else {
            echo "Please provide a task description.\n";
        }
        break;

    case 'update':
        if (isset($args[1], $args[2])) {
            updateTask((int)$args[1], $args[2]);
        } else {
            echo "Usage: php task-cli.php update <id> \"new description\"\n";
        }
        break;

    case 'delete':
        if (isset($args[1])) {
            deleteTask((int)$args[1]);
        } else {
            echo "Usage: php task-cli.php delete <id>\n";
        }
        break;

    case 'mark-in-progress':
        if (isset($args[1])) {
            markStatus((int)$args[1], 'in-progress');
        } else {
            echo "Usage: php task-cli.php mark-in-progress <id>\n";
        }
        break;

    case 'mark-done':
        if (isset($args[1])) {
            markStatus((int)$args[1], 'done');
        } else {
            echo "Usage: php task-cli.php mark-done <id>\n";
        }
        break;

    case 'list':
        $filter = $args[1] ?? null;
        listTasks($filter);
        break;

    default:
        echo "Unknown command: $command\n";
        break;
}

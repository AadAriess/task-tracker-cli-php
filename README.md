# 🧩 Task Tracker CLI (PHP)

Task Tracker CLI is a simple Command Line Interface application for adding, updating, and tracking your tasks. This project is built using **pure PHP**, without any external frameworks or libraries, and stores task data in a local `tasks.json` file.

---

## 🚀 Features

- Add a new task
- Update an existing task's description
- Delete a task
- Mark a task as `todo`, `in-progress`, or `done`
- List all tasks or filter by status
- Task data is stored in a local JSON file

---

## 📦 How to Run

### ✅ Requirements
- [PHP](https://www.php.net/) installed (PHP 7.4 or higher recommended)
- Use Command Prompt, PowerShell, Git Bash, or any terminal

---

## 💻 CLI Commands

> All commands are run in the format:
> ```bash
> php task-cli.php <command> [options]
> ```

### ➕ Add a Task
```bash
php task-cli.php add "Learn PHP CLI"
```

### ✏️ Update a Task
```bash
php task-cli.php update 1 "Learn PHP CLI in depth"
```

### 🗑️ Delete a Task
```bash
php task-cli.php delete 1
```

### 🔁 Mark a Task Status
```bash
php task-cli.php mark-in-progress 1
php task-cli.php mark-done 1
```

### 📋 List All Tasks
```bash
php task-cli.php list
```

### 📌 List Tasks by Status
```bash
php task-cli.php list todo
php task-cli.php list in-progress
php task-cli.php list done
```

https://roadmap.sh/projects/task-tracker
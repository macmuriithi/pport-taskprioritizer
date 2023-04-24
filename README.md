# TaskPrioritizer

TaskPrioritizer is a PHP class that prioritizes a list of tasks based on their dependencies and difficulty using a directed acyclic graph (DAG) and topological sort.

## Installation

The `TaskPrioritizer` class can be installed using Composer:
composer require pport/task-prioritizer

Alternatively, you can clone this repository or download the `TaskPrioritizer.php` file and include it in your project.

## Usage

To use the `TaskPrioritizer` class, create an instance of the class and pass in three arrays: `$tasks`, `$dependencies`, and `$difficulty`.

```php
// Define the tasks, dependencies, and difficulties
$tasks = array('A', 'B', 'C', 'D', 'E', 'F');
$dependencies = array(
  'A' => array('B', 'C'),
  'D' => array('B', 'E'),
  'E' => array('C', 'F'),
);
$difficulty = array(
  'A' => 3,
  'B' => 1,
  'C' => 2,
  'D' => 4,
  'E' => 2,
  'F' => 1,
);

// Create a new TaskPrioritizer instance
$taskPrioritizer = new TaskPrioritizer($tasks, $dependencies, $difficulty);

// Prioritize the tasks using the TaskPrioritizer instance
$taskOrder = $taskPrioritizer->prioritizeTasks();

// Output the prioritized task order
echo "Task order: " . implode(', ', $taskOrder);
```

## Output

This will output:

Task order: B, C, A, F, E, D

This indicates that the tasks should be performed in the order of B, C, A, F, E, D, with B being the first task to be performed because it has no dependencies and has the lowest difficulty. The other tasks are performed in order of increasing difficulty, while respecting their dependencies in the directed acyclic graph.

## Contributing

Contributions to the TaskPrioritizer class are welcome! Please submit a pull request with your changes.

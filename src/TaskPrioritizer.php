<?php
class TaskPrioritizer
{
    private $tasks;
    private $dependencies;
    private $difficulty;

    public function __construct($tasks, $dependencies, $difficulty)
    {
        // Initialize the class properties with the provided values
        $this->tasks = $tasks;
        $this->dependencies = $dependencies;
        $this->difficulty = $difficulty;
    }

    public function prioritizeTasks()
    {
        // This function returns an array containing the tasks in order of priority

        $taskOrder = array(); // The order in which to perform the tasks
        $visited = array(); // The tasks that have been visited
        $taskQueue = array(); // The tasks that are ready to be processed

        // Find source nodes (tasks with no dependencies) and add them to the queue
        foreach ($this->tasks as $task) {
            if (!isset($this->dependencies[$task])) {
                $taskQueue[] = $task;
                $visited[$task] = true;
            }
        }

        // Perform a topological sort
        while (!empty($taskQueue)) {
            // Find the task with the lowest difficulty in the queue
            $minDifficulty = INF;
            $minTask = null;
            foreach ($taskQueue as $task) {
                if ($this->difficulty[$task] < $minDifficulty) {
                    $minDifficulty = $this->difficulty[$task];
                    $minTask = $task;
                }
            }

            // Add the task to the task order
            $task = $minTask;
            $taskOrder[] = $task;

            // Add any dependent tasks to the queue if they are ready to be processed
            if (isset($this->dependencies[$task])) {
                foreach ($this->dependencies[$task] as $dependentTask) {
                    if (!isset($visited[$dependentTask])) {
                        $isReady = true;
                        foreach ($this->tasks as $task) {
                            if (isset($this->dependencies[$task]) && in_array($dependentTask, $this->dependencies[$task])) {
                                $isReady = false;
                                break;
                            }
                        }

                        if ($isReady) {
                            $taskQueue[] = $dependentTask;
                            $visited[$dependentTask] = true;
                        }
                    }
                }
            }

            // Remove the processed task from the queue
            $taskQueue = array_diff($taskQueue, array($task));
        }

        return $taskOrder;
    }
}

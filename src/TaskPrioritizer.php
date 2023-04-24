<?php

namespace Pport\Agi;

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
        $taskQueue = new \SplPriorityQueue(); // The tasks that are ready to be processed

        // Add all tasks to the queue
        foreach ($this->tasks as $task) {
            $taskQueue->insert($task, $this->difficulty[$task]);
        }

        // Perform a topological sort
        while (!$taskQueue->isEmpty()) {
            // Get the task with the highest priority
            $task = $taskQueue->extract();

            // Add the task to the task order
            $taskOrder[] = $task;

            // Add any dependent tasks to the queue if they are ready to be processed
            if (isset($this->dependencies[$task])) {
                foreach ($this->dependencies[$task] as $dependentTask) {
                    $isReady = true;
                    foreach ($this->tasks as $task) {
                        if (isset($this->dependencies[$task]) && in_array($dependentTask, $this->dependencies[$task])) {
                            $isReady = false;
                            break;
                        }
                    }

                    if ($isReady && !isset($visited[$dependentTask])) {
                        $taskQueue->insert($dependentTask, $this->difficulty[$dependentTask]);
                    }
                }
            }

            // Mark the task as visited
            $visited[$task] = true;
        }

        return $taskOrder;
    }
}
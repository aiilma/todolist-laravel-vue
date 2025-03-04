import type {Task} from "./task.ts";

export interface TasksResponse {
    total_tasks_count: number;
    tasks: Task[];
}
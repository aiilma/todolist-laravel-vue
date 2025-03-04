import type {TaskStatus} from "../types/task.ts";

export function taskStatusRenderer(status: TaskStatus): string {
    switch (status) {
        case "new":
            return "New";
        case "in_progress":
            return "In Progress";
        case "completed":
            return "Completed";
        default:
            return status;
    }
}
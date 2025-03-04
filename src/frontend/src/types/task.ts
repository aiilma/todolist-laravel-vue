import type {Id, Nullable} from "./basic.ts";

export type TaskStatus = 'new' | 'in_progress' | 'completed'

export interface Task {
    id: Id;
    title: string;
    description?: Nullable<string>;
    status: TaskStatus;
    deadline?: Nullable<string>;
}
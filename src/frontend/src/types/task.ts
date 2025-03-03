export interface Task {
    id: number;
    title: string;
    description?: string | null;
    status: 'new' | 'in_progress' | 'completed';
    deadline?: string | null;
}
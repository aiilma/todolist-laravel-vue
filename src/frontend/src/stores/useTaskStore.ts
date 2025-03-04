import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useAxiosStore} from './useAxiosStore';
import type {Task} from "../types/task.ts";
import type {TasksResponse} from "../types/api.ts";

export const useTaskStore = defineStore('TaskStore', () => {
    const {http} = useAxiosStore();
    const tasks = ref<Task[]>([]);
    const totalTasksCount = ref<number>(0);

    const fetchTasks = async (params = {}) => {
        try {
            const response = await http.get<TasksResponse>('/tasks', { params });
            tasks.value = response.data.tasks;
            totalTasksCount.value = response.data.total_tasks_count;
        } catch (error) {
            console.error('Failed to fetch tasks:', error);
        }
    };

    const fetchTask = async (id: string) => {
        try {
            const response = await http.get<Task>(`/tasks/${id}`);
            return response.data;
        } catch (error) {
            console.error('Failed to fetch task:', error);
            throw error;
        }
    };

    const createTask = async (task: Partial<Task>) => {
        try {
            const response = await http.post<Task>('/tasks', task);
            tasks.value.push(response.data);
        } catch (error) {
            console.error('Failed to create task:', error);
        }
    };

    const updateTask = async (id: string, updatedTask: Partial<Task>) => {
        try {
            const response = await http.put<Task>(`/tasks/${id}`, updatedTask);
            const index = tasks.value.findIndex((task: Task) => task.id === +id);
            if (index !== -1) {
                tasks.value[index] = response.data;
            }
        } catch (error) {
            console.error('Failed to update task:', error);
        }
    };

    const deleteTask = async (id: number) => {
        try {
            await http.delete(`/tasks/${id}`);
            tasks.value = tasks.value.filter((task: Task) => task.id !== id);
            totalTasksCount.value--
        } catch (error) {
            console.error('Failed to delete task:', error);
        }
    };

    return {
        tasks,
        totalTasksCount,
        fetchTasks,
        fetchTask,
        createTask,
        updateTask,
        deleteTask
    };
});
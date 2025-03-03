import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useAxiosStore} from './useAxiosStore';
import type {Task} from "../types/task.ts";

export const useTaskStore = defineStore('TaskStore', () => {
    const {http} = useAxiosStore();
    const tasks = ref<Task[]>([]);
    const totalTasksCount = ref<number>(0);

    const fetchTasks = async (params = {}) => {
        try {
            const response = await http.get('/tasks', { params });
            tasks.value = response.data.tasks;
            totalTasksCount.value = response.data.total_tasks_count;
        } catch (error) {
            console.error('Failed to fetch tasks:', error);
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
        deleteTask
    };
});
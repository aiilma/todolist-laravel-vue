import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useAxiosStore} from './useAxiosStore';
import type {Task} from "../types/task.ts";

export const useTaskStore = defineStore('TaskStore', () => {
    const {http} = useAxiosStore();
    const tasks = ref<Task[]>([]);
    const totalTasksCount = ref<number>(0);

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
        deleteTask
    };
});
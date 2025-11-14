<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { type BreadcrumbItem } from '@/types'


const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Expense Tracking', href: '/expenses-tracking' },
]

const expenses = ref([
    {
        id: 1,
        date: '2025-08-10',
        category: 'Travel',
        description: 'Taxi fare to client meeting',
        amount: 250,
        status: 'Pending',
    },
    {
        id: 2,
        date: '2025-08-12',
        category: 'Office Supplies',
        description: 'Printer ink',
        amount: 1200,
        status: 'Approved',
    },
    {
        id: 3,
        date: '2025-08-14',
        category: 'Meals',
        description: 'Team lunch',
        amount: 800,
        status: 'Rejected',
    },
]);

const categories = ['Travel', 'Meals', 'Office Supplies', 'Utilities', 'Other'];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Expense Tracking</h1>

            <!-- Expense Entry Form -->
            <div class="space-y-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Add Expense</h2>

                <form class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Category </label>
                        <select
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        >
                            <option disabled selected>Select a category</option>
                            <option v-for="c in categories" :key="c">{{ c }}</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Amount </label>
                        <input
                            type="number"
                            placeholder="₱0.00"
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        />
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Description </label>
                        <input
                            type="text"
                            placeholder="Enter description"
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        />
                    </div>

                    <!-- Receipt Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"> Receipt Upload </label>
                        <input
                            type="file"
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-800 file:cursor-pointer focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end md:col-span-2">
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-white shadow transition duration-200 hover:bg-blue-700">
                            Submit Expense
                        </button>
                    </div>
                </form>
            </div>

            <!-- Expense Table -->
            <div class="rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">Submitted Expenses</h2>
                <div class="overflow-x-auto rounded-2xl">
                    <table class="w-full border-collapse">
                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-200">
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Amount</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            <tr
                                v-for="e in expenses"
                                :key="e.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/50"
                            >
                                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ e.date }}</td>
                                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ e.category }}</td>
                                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ e.description }}</td>
                                <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-400">₱{{ e.amount }}</td>
                                <td class="px-6 py-4">
                                    <!-- Status Badges -->
                                    <span
                                        v-if="e.status === 'Approved'"
                                        class="rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white shadow-sm"
                                    >
                                        Approved
                                    </span>
                                    <span
                                        v-else-if="e.status === 'Pending'"
                                        class="rounded-full bg-yellow-500 px-3 py-1 text-xs font-semibold text-white shadow-sm"
                                    >
                                        Pending
                                    </span>
                                    <span v-else class="rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                        Rejected
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

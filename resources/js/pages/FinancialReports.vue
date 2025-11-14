<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { BarChart, LineChart, PieChart } from 'lucide-vue-next';
import { ref } from 'vue';

// Example reactive data (replace later with backend props)
// const incomeData = [5000, 7000, 6000, 8000, 7500];
// const expenseData = [3000, 4000, 3500, 4500, 4200];
const budgetProgress = 65;
const dateRange = ref({ start: '2025-01-01', end: '2025-08-01' });
</script>

<template>
    <AppLayout title="Financial Reports">
        <div class="space-y-6 p-6">
            <!-- Page Title -->
            <h1 class="text-2xl font-semibold">Financial Reports</h1>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Income Summary -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2"> <BarChart class="h-5 w-5 text-green-600" /> Income Summary </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="mb-2 text-sm text-gray-500">Monthly Income Trend</p>
                        <!-- Placeholder for chart -->
                        <div class="flex h-40 items-center justify-center rounded-lg bg-gray-100 text-gray-400">[Income Chart]</div>
                    </CardContent>
                </Card>

                <!-- Expense Tracking -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2"> <LineChart class="h-5 w-5 text-red-600" /> Expense Tracking </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="mb-2 text-sm text-gray-500">Monthly Expenses Overview</p>
                        <div class="flex h-40 items-center justify-center rounded-lg bg-gray-100 text-gray-400">[Expense Chart]</div>
                    </CardContent>
                </Card>

                <!-- Budget Progress -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2"> <PieChart class="h-5 w-5 text-blue-600" /> Budget Allocation </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="mb-2 text-sm text-gray-500">Budget Utilization</p>
                        <div class="h-4 w-full rounded-full bg-gray-200">
                            <div class="h-4 rounded-full bg-blue-600" :style="{ width: budgetProgress + '%' }"></div>
                        </div>
                        <p class="mt-2 text-sm font-medium">{{ budgetProgress }}% used</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Date Range Selector -->
            <Card class="rounded-2xl shadow-md">
                <CardHeader>
                    <CardTitle class="text-gray-800 dark:text-gray-200">Custom Date Range</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Start Date -->
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400"> Start Date </label>
                            <input
                                type="date"
                                v-model="dateRange.start"
                                class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            />
                        </div>

                        <!-- End Date -->
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400"> End Date </label>
                            <input
                                type="date"
                                v-model="dateRange.end"
                                class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                            />
                        </div>

                        <!-- Apply Button -->
                        <button class="rounded-xl bg-blue-600 px-5 py-2 text-white shadow-sm transition hover:bg-blue-700 dark:hover:bg-blue-500">
                            Apply
                        </button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

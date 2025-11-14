<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Transaction History</h1>

                <!-- Export Buttons -->
                <div class="flex space-x-2">
                    <a href="/transactions/export/csv"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Export CSV</a>
                    <a href="/transactions/export/pdf"
                        class="rounded-xl bg-green-600 px-4 py-2 text-white hover:bg-green-700">Export PDF</a>
                </div>
            </div>

            <!-- Filters + Search -->
            <div class="mb-6 flex flex-wrap gap-4">
                <input type="text" v-model="searchQuery" placeholder="Search transactions..."
                    class="flex-1 rounded-xl border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                <select v-model="filterType"
                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-gray-700 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                    <option value="">All Types</option>
                    <option value="payment">Payment</option>
                    <option value="expense">Expense</option>
                    <option value="membership">Membership</option>
                </select>

                <input type="date" v-model="filterDate"
                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200" />
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto rounded-2xl shadow">
                <table class="min-w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 text-sm text-gray-700 uppercase dark:bg-gray-800 dark:text-gray-300">
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Description</th>
                            <th class="px-6 py-3">Amount</th>
                            <th class="px-6 py-3">Status</th>
                            <th v-if="isAdmin" class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(tx, index) in filteredTransactions" :key="index"
                            class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                            <td class="px-6 py-3 text-gray-700 dark:text-gray-200">{{ tx.date }}</td>
                            <td class="px-6 py-3 text-gray-700 capitalize dark:text-gray-200">{{ tx.type }}</td>
                            <td class="px-6 py-3 text-gray-700 dark:text-gray-200">{{ tx.description }}</td>
                            <td class="px-6 py-3 font-semibold text-green-600 dark:text-green-400">₱{{ tx.amount }}</td>
                            <td class="px-6 py-3">
                                <span :class="[
                                    'rounded-full px-3 py-1 text-xs font-semibold',
                                    tx.status === 'Completed'
                                        ? 'bg-green-500 text-white'
                                        : tx.status === 'Pending'
                                            ? 'bg-yellow-500 text-white'
                                            : 'bg-red-500 text-white',
                                ]">
                                    {{ tx.status }}
                                </span>
                            </td>
                            <td v-if="isAdmin" class="px-6 py-3 text-gray-700 dark:text-gray-200">{{ tx.user }}</td>
                            <td class="px-6 py-3">
                                <a v-if="tx.status === 'Completed'" :href="`/transactions/${tx.id}/receipt`"
                                    class="text-blue-600 hover:underline" download>
                                    Download Receipt
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (static for now) -->
            <div class="mt-6 flex items-center justify-between text-sm text-gray-600">
                <p>Showing {{ filteredTransactions.length }} of {{ transactions.length }} transactions</p>
                <div class="flex space-x-2">
                    <button class="rounded bg-gray-300 px-3 py-1 hover:bg-gray-400">Prev</button>
                    <button class="rounded bg-gray-300 px-3 py-1 hover:bg-gray-400">Next</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { computed, ref } from 'vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Transaction History', href: '/transactions' }
];

const props = defineProps<{
    transactions: Array<any>,
    isAdmin: boolean
}>();

const transactions = ref(props.transactions);
const isAdmin = props.isAdmin;

const searchQuery = ref('');
const filterType = ref('');
const filterDate = ref('');

const filteredTransactions = computed(() => {
    return transactions.value.filter((tx) => {
        const matchesSearch =
            tx.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            tx.type.toLowerCase().includes(searchQuery.value.toLowerCase());

        const matchesType = filterType.value ? tx.type === filterType.value : true;
        const matchesDate = filterDate.value ? tx.date.startsWith(filterDate.value) : true;

        return matchesSearch && matchesType && matchesDate;
    });
});
</script>

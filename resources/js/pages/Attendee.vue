<script setup lang="ts">
import { computed, reactive, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import { Users, UserCheck, QrCode, UserX, Filter, X, Download } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

// Define Attendee type locally if not exported from '@/types'
type Attendee = {
    id: number
    first_name: string
    last_name: string
    email: string
    status: 'present' | 'absent'
    checkin_type?: 'qr' | 'manual'
    date: string
}
import AppLayout from '@/layouts/AppLayout.vue'

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Attendee', href: '/attendees' },
]

const props = defineProps<{ attendees: Attendee[] }>()


// UI state
const showFilters = ref(false)

// Filters & search
const search = ref('')
const filters = reactive({
    status: '' as '' | 'present' | 'absent' | 'qr' | 'manual',
    from: '' as string | '',
    to: '' as string | '',
})

// Derived list
const filtered = computed(() => {
    return props.attendees.filter(a => {
        // search filter
        const term = search.value.trim().toLowerCase()
        const matchesSearch = !term || [
        `${a.first_name} ${a.last_name}`,
        a.email,
    ].some(v => v.toLowerCase().includes(term))

    // status filter (including qr/manual pseudo-status)
    const f = filters.status
    const matchesStatus = !f
    || (f === 'present' && a.status === 'present')
    || (f === 'absent' && a.status === 'absent')
    || (f === 'qr' && a.status === 'present' && a.checkin_type === 'qr')
    || (f === 'manual' && a.status === 'present' && a.checkin_type === 'manual')

    // date range
    const fromOk = !filters.from || a.date >= filters.from
    const toOk = !filters.to || a.date <= filters.to

    return matchesSearch && matchesStatus && fromOk && toOk
    })
})

// Stats
const totalPresent = computed(() => props.attendees.filter(a => a.status === 'present').length)
const manualCheckins = computed(() => props.attendees.filter(a => a.status === 'present' && a.checkin_type === 'manual').length)
const qrCheckins = computed(() => props.attendees.filter(a => a.status === 'present' && a.checkin_type === 'qr').length)
const totalAbsent = computed(() => props.attendees.filter(a => a.status === 'absent').length)

// Helpers
const initials = (a: Attendee) => {
    const parts = [a.first_name, a.last_name].filter(Boolean)
    return parts.map(p => p[0]).join('').toUpperCase()
}

const clearFilters = () => {
  filters.status = ''
  filters.from = ''
  filters.to = ''
  search.value = ''
}

const formatDate = (dateStr: string) => {
  const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'short', day: 'numeric' }
  return new Date(dateStr).toLocaleDateString(undefined, options)
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Attendee Management - PSITS Tech Summit 2025" />
        <div class="min-h-screen bg-gray-950">
            <div class="max-w-7xl mx-auto px-4 py-8">

                <!-- Header -->
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Attendee Management</h1>
                        <p class="text-gray-400">
                        Manage registrations and check-ins for PSITS Tech Summit 2025
                        </p>
                    </div>
                    <a
                        href="/analytics/export"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium"
                    >
                        <Download class="w-4 h-4" />
                        Export
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-900 rounded-2xl shadow p-6 flex items-center">
                        <div
                        class="w-12 h-12 rounded-full bg-blue-600/20 flex items-center justify-center text-blue-400 mr-4"
                        >
                            <Users class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Total Present</p>
                            <p class="text-3xl font-bold text-white">{{ totalPresent }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-2xl shadow p-6 flex items-center">
                        <div
                        class="w-12 h-12 rounded-full bg-green-600/20 flex items-center justify-center text-green-400 mr-4"
                        >
                            <UserCheck class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Manual Check-ins</p>
                            <p class="text-3xl font-bold text-white">{{ manualCheckins }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-2xl shadow p-6 flex items-center">
                        <div
                        class="w-12 h-12 rounded-full bg-purple-600/20 flex items-center justify-center text-purple-400 mr-4"
                        >
                            <QrCode class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">QR Check-ins</p>
                            <p class="text-3xl font-bold text-white">{{ qrCheckins }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-2xl shadow p-6 flex items-center">
                        <div
                        class="w-12 h-12 rounded-full bg-red-600/20 flex items-center justify-center text-red-400 mr-4"
                        >
                            <UserX class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Absent</p>
                            <p class="text-3xl font-bold text-white">{{ totalAbsent }}</p>
                        </div>
                    </div>
                </div>

                <!-- Search + Filter + Add Toolbar -->
                <div class="flex flex-wrap items-center gap-2 mb-6">
                    <!-- Search -->
                    <div class="flex-1 min-w-[200px]">
                        <input
                        v-model="search"
                        type="text"
                        placeholder="Search by name or email"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Filter Toggle -->
                    <div>
                        <button
                        @click="showFilters = !showFilters"
                        class="flex items-center gap-2 px-3 py-2 bg-gray-700 rounded hover:bg-gray-600"
                        >
                        <Filter class="w-4 h-4" /> Filter
                        </button>
                    </div>
                </div>

                <!-- Collapsible Filter Section -->
                <div v-if="showFilters" class="p-6 border border-gray-700 bg-gray-900 rounded-2xl mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status -->
                    <div class="flex flex-col">
                        <label for="status" class="text-sm text-gray-300 mb-1">Status</label>
                        <select
                            id="status"
                            v-model="filters.status"
                            class="flex items-center gap-2 px-3 py-2 bg-gray-700 rounded hover:bg-gray-600"
                        >
                            <option value="">All Status</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="qr">QR Check-in</option>
                            <option value="manual">Manual Check-in</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="flex flex-col">
                    <label for="dateFrom" class="text-sm text-gray-300 mb-1">Date From</label>
                    <input
                        id="dateFrom"
                        v-model="filters.from"
                        type="date"
                        class="flex items-center gap-2 px-3 py-2 bg-gray-700 rounded hover:bg-gray-600"
                    />
                    </div>

                    <!-- Date To -->
                    <div class="flex flex-col">
                    <label for="dateTo" class="text-sm text-gray-300 mb-1">Date To</label>
                    <input
                        id="dateTo"
                        v-model="filters.to"
                        type="date"
                        class="flex items-center gap-2 px-3 py-2 bg-gray-700 rounded hover:bg-gray-600"
                    />
                    </div>
                </div>

                <!-- Clear Filters -->
                <div class="mt-4 flex justify-end">
                    <button
                    @click="clearFilters"
                    class="w-full md:w-auto rounded border border-gray-600 bg-gray-800 hover:bg-gray-700 text-gray-200 px-3 py-2 text-sm font-medium flex items-center gap-2 focus:ring-2 focus:ring-blue-500"
                    >
                        <X class="w-4 h-4" /> Clear Filters
                    </button>
                </div>
            </div>

                <!-- Attendee List -->
                <div class="bg-gray-900 rounded-2xl shadow overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h2 class="text-lg font-semibold text-white">Attendee List</h2>
                    </div>

                    <!-- Attendee Items -->
                    <div class="divide-y divide-gray-700">
                        <div
                            v-for="attendee in filtered"
                            :key="attendee.id"
                            class="px-6 py-4 flex items-center hover:bg-gray-800"
                        >
                            <div
                                class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-200 font-semibold mr-4"
                            >
                                {{ initials(attendee) }}
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-base font-medium text-white">
                                {{ attendee.first_name }} {{ attendee.last_name }}
                                </h3>
                                <p class="text-sm text-gray-400">{{ attendee.email }}</p>
                                <p class="text-xs text-gray-600">{{ formatDate(attendee.date) }}</p>
                            </div>
                            <div class="ml-4">
                                <!-- Absent -->
                                <span
                                v-if="attendee.status === 'absent'"
                                class="px-2 py-1 rounded-full bg-gray-700 text-gray-300 text-xs font-medium"
                                >
                                Absent
                                </span>

                                <!-- Present -->
                                <span
                                v-else
                                class="px-2 py-1 rounded-full bg-green-700/20 text-green-400 text-xs font-medium flex items-center"
                                ><component
                                    :is="attendee.checkin_type === 'qr' ? QrCode : UserCheck"
                                    class="w-3 h-3 mr-1"
                                />
                                    {{ attendee.checkin_type === 'qr' ? 'QR' : 'Manual' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
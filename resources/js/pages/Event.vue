<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import { CalendarDays, Users2, CalendarCheck2, Award, Plus, Filter } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'
import AppLayout from '@/layouts/AppLayout.vue'
import EventForm from '@/components/EventForm.vue' 
import EventDetail from '@/components/EventDetail.vue'

const isEditing = ref(false)

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Events', href: '/events' },
]

// Stats 
const stats = ref([
    { label: 'Total Events', value: 24, icon: CalendarCheck2, color: 'bg-blue-600' },
    { label: 'Active Registrations', value: 187, icon: Users2, color: 'bg-green-500' },
    { label: 'Upcoming Events', value: 8, icon: CalendarDays, color: 'bg-pink-500' },
    { label: 'Average Attendance', value: '94.2%', icon: Award, color: 'bg-sky-500' },
])

interface Event {
    id: number
    title: string
    date: string
    time: string
    venue: string
    status: 'Upcoming' | 'Ongoing' | 'Completed'
    registered: string
}

function openCreateForm() {
    isEditing.value = false
    selectedEvent.value = null
    showForm.value = true
}

const recentEvents = ref<Event[]>([
    { id: 1, title: 'PSITS Tech Summit 2025', date: 'September 15, 2025', time: '9:00 AM', venue: 'PSITS Auditorium', status: 'Upcoming', registered: '87/150' },
    { id: 2, title: 'Coding Bootcamp', date: 'September 20, 2025', time: '10:00 AM', venue: 'Computer Lab 1', status: 'Ongoing', registered: '28/30' },
    { id: 3, title: 'Web Development Workshop', date: 'September 10, 2025', time: '2:00 PM', venue: 'Computer Lab 2', status: 'Completed', registered: '45/50' },
    { id: 4, title: 'AI & Machine Learning Seminar', date: 'September 25, 2025', time: '1:00 PM', venue: 'Main Hall', status: 'Upcoming', registered: '120/200' },
])

const recentActivity = ref([
    { text: 'New registration from Maria Santos', time: '3 hours ago', color: 'text-green-400' },
    { text: 'Event details updated', time: '1 day ago', color: 'text-yellow-400' },
    { text: 'Reminder sent to 87 attendees', time: '2 days ago', color: 'text-blue-400' },
])

// Toggle form visibility
const showForm = ref(false)

// Recent Events Filter
const eventFilter = ref('All')
const isEventFilterOpen = ref(false)

const eventFilterOptions = [
    'All',
    'Upcoming',
    'Ongoing', 
    'Completed'
]

// Filtered events based on status
const filteredRecentEvents = computed(() => {
    if (eventFilter.value === 'All') {
        return recentEvents.value
    }
    return recentEvents.value.filter(event => event.status === eventFilter.value)
})

// Add selected event and detail modal visibility
const selectedEvent = ref<Event | null>(null)
const showEventDetail = ref(false)

// Function to open event detail
function openEventDetail(event: Event) {
    selectedEvent.value = event
    showEventDetail.value = true
}

// Function to close event detail
function closeEventDetail() {
    selectedEvent.value = null
    showEventDetail.value = false
}

// Function to handle new event creation
function handleEventCreated(newEvent: Event) {
    // Add the new event to the beginning of the recent events array
    recentEvents.value.unshift(newEvent)
    
    // Add to recent activity
    recentActivity.value.unshift({
        text: `New event created: ${newEvent.title}`,
        time: 'Just now',
        color: 'text-green-400'
    })
    
    // Keep only the latest 3 activities
    if (recentActivity.value.length > 3) {
        recentActivity.value = recentActivity.value.slice(0, 3)
    }
    
    // Show success message (optional)
    console.log('Event created successfully:', newEvent.title)
}

// Open EventForm for editing
function handleEditEvent(event: Event) {
    selectedEvent.value = event
    isEditing.value = true
    showForm.value = true
    showEventDetail.value = false   // hide detail modal when editing
}

// When form is saved, update existing event
function handleEventUpdated(updatedEvent: Event) {
    const index = recentEvents.value.findIndex(e => e.id === updatedEvent.id)
    if (index !== -1) {
        recentEvents.value[index] = updatedEvent
    }
    isEditing.value = false
    showForm.value = false
    selectedEvent.value = null
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Event Management" />
            <div class="p-6 space-y-6 bg-gray-950 min-h-screen">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Event Management</h1>
                        <p class="text-gray-400">Manage and monitor PSITS events, registrations, and analytics</p>
                    </div>
                    <button
                        @click="openCreateForm"
                        class="flex items-center gap-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white px-4 py-2 rounded-xl shadow-lg hover:opacity-90 hover:shadow-xl hover:scale-105 transition-all duration-300"
                    >
                        <Plus class="w-5 h-5" /> Create Event
                    </button>
                </div>
            <!-- Stats cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="(item, index) in stats"
                    :key="index"
                    class="rounded-2xl p-6 text-white shadow-lg flex flex-col gap-2 hover:scale-105 hover:shadow-2xl transition-transform duration-300 cursor-pointer"
                    :class="item.color"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">{{ item.label }}</span>
                        <component :is="item.icon" class="w-6 h-6 opacity-80" />
                    </div>
                    <div class="text-3xl font-bold">{{ item.value }}</div>
                </div>
            </div>
            <!-- Event Form -->
            <div v-if="showForm" class="mt-6">
                <EventForm 
                    :isOpen="showForm" 
                    :event="isEditing ? selectedEvent : null"
                    :isEditing="isEditing"
                    @close="() => { showForm = false; isEditing = false; selectedEvent = null }"
                    @created="handleEventCreated" 
                    @updated="handleEventUpdated"
                />
            </div>
                <!-- Event Detail Modal -->
                <EventDetail
                    v-if="selectedEvent"
                    :event="selectedEvent"
                    :isOpen="showEventDetail"
                    @close="closeEventDetail"
                    @edit="handleEditEvent"  
                />
            <!-- Recent Events & Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Recent Events with Filter -->
                <div class="bg-gray-900 p-4 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-white">Recent Events</h2>
                        
                        <!-- Filter Dropdown -->
                        <div class="relative">
                            <button 
                                @click="isEventFilterOpen = !isEventFilterOpen"
                                class="flex items-center gap-2 px-3 py-1.5 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 hover:text-white transition-all duration-200"
                            >
                                <Filter class="w-4 h-4" />
                                <span class="text-sm">{{ eventFilter }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': isEventFilterOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        <!-- Dropdown Menu -->
                        <div 
                            v-if="isEventFilterOpen" 
                            class="absolute right-0 mt-2 w-32 bg-gray-800 border border-gray-700 rounded-lg shadow-lg z-10"
                        >
                            <button
                            v-for="option in eventFilterOptions"
                            :key="option"
                            @click="eventFilter = option; isEventFilterOpen = false"
                            class="w-full text-left px-3 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white first:rounded-t-lg last:rounded-b-lg transition-colors duration-150"
                            :class="{ 'bg-gray-700 text-white': eventFilter === option }"
                            >
                            {{ option }}
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Events List -->
                <div class="space-y-3">
                    <div
                    v-for="event in filteredRecentEvents"
                    :key="event.id"
                    class="p-4 bg-gray-800 rounded-xl flex justify-between items-center 
                            hover:bg-gray-750 hover:shadow-lg hover:scale-[1.02] 
                            transition-all duration-200 cursor-pointer group"
                    @click="openEventDetail(event)"
                    >
                        <div>
                            <h3 class="font-semibold text-white group-hover:text-blue-300 transition-colors">
                            {{ event.title }}
                            </h3>
                            <p class="text-sm text-gray-400 group-hover:text-gray-300 transition-colors">
                            {{ event.date }} • {{ event.time }} • {{ event.venue }}
                            </p>
                        </div>
                            <div class="text-right">
                                <span
                                class="px-3 py-1 rounded-full text-xs font-medium group-hover:scale-110 transition-transform"
                                :class="{
                                    'bg-blue-600 text-white hover:bg-blue-700': event.status === 'Upcoming',
                                    'bg-green-600 text-white hover:bg-green-700': event.status === 'Ongoing',
                                    'bg-gray-600 text-white hover:bg-gray-700': event.status === 'Completed',
                                }"
                                >
                                {{ event.status }}
                                </span>
                                <p class="text-sm text-gray-300 mt-1 group-hover:text-white transition-colors">
                                {{ event.registered }} registered
                                </p>
                            </div>
                        </div>              
                    <!-- Empty State -->
                    <div 
                    v-if="filteredRecentEvents.length === 0" 
                    class="text-center py-8 text-gray-400 hover:text-gray-300 transition-colors"
                    >
                        <p>No {{ eventFilter.toLowerCase() }} events found</p>
                    </div>
                </div>
            </div>
                <!-- Recent Activity -->
                <div class="bg-gray-900 p-4 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-lg font-semibold text-white mb-4">Recent Activity</h2>
                    <ul class="space-y-3">
                        <li
                            v-for="(activity, index) in recentActivity"
                            :key="index"
                            class="flex justify-between text-sm hover:bg-gray-800 p-2 rounded-lg transition-colors duration-200"
                        >
                            <span :class="[activity.color, 'hover:underline transition-all']">{{ activity.text }}</span>
                            <span class="text-gray-500 hover:text-gray-300 transition-colors">{{ activity.time }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

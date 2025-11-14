<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Calendar, Clock, MapPin, Users, Edit, Trash2 } from 'lucide-vue-next'

interface Event {
    id: number
    title: string
    description: string
    date: string
    time: string
    venue: string
    address: string
    status: 'Upcoming' | 'Ongoing' | 'Completed'
    registered: string
    max_capacity: number
    organizer: string
}

const props = defineProps<{
    event: Event
    isOpen: boolean
}>()

const emit = defineEmits<{
    close: []
    edit: [event: Event]
}>()

const showDeleteConfirm = ref(false)

function editEvent() {
    emit('edit', props.event)
}

function deleteEvent() {
    router.delete(`/events/${props.event.id}`, {
        onSuccess: () => {
        emit('close')
        }
    })
}

function cancel() {
    emit('close')
}
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-900 rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <!-- Header -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2">{{ event.title }}</h1>
                        <span
                        class="px-3 py-1 rounded-full text-sm font-medium"
                        :class="{
                            'bg-blue-600 text-white': event.status === 'Upcoming',
                            'bg-green-600 text-white': event.status === 'Ongoing',
                            'bg-gray-600 text-white': event.status === 'Completed',
                        }"
                        >
                        {{ event.status }}
                        </span>
                    </div>
                    <button
                        @click="cancel"
                        class="text-gray-400 hover:text-white transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-300">{{ event.description }}</p>
            </div>

        <!-- Event Details -->
        <div class="p-6 space-y-6">
            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <Calendar class="w-5 h-5 text-blue-400 mr-3" />
                        <div>
                            <p class="text-sm text-gray-400">Date</p>
                            <p class="text-white">{{ event.date }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Clock class="w-5 h-5 text-blue-400 mr-3" />
                        <div>
                            <p class="text-sm text-gray-400">Time</p>
                            <p class="text-white">{{ event.time }}</p>
                        </div>
                    </div>
                </div>

            <div class="space-y-4">
                <div class="flex items-center">
                    <MapPin class="w-5 h-5 text-blue-400 mr-3" />
                    <div>
                        <p class="text-sm text-gray-400">Location</p>
                        <p class="text-white">{{ event.venue }}</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <Users class="w-5 h-5 text-blue-400 mr-3" />
                    <div>
                        <p class="text-sm text-gray-400">Registration</p>
                        <p class="text-white">{{ event.registered }} registered</p>
                    </div>
                </div>
            </div>
        </div>

            <hr class="border-gray-700">

            <!-- Organizer -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-3">Organizer</h3>
                <p class="text-gray-300 font-medium">Philippine Society of IT Students</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    @click="editEvent"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    <Edit class="w-4 h-4" />
                    Edit Event
                </button>
                <button
                    @click="showDeleteConfirm = true"
                    class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                >
                    <Trash2 class="w-4 h-4" />
                    Delete
                </button>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60">
            <div class="bg-gray-800 p-6 rounded-lg max-w-md mx-4">
                <h3 class="text-lg font-semibold text-white mb-4">Confirm Deletion</h3>
                <p class="text-gray-300 mb-6">Are you sure you want to delete this event? This action cannot be undone.</p>
            <div class="flex gap-3 justify-end">
                <button
                    @click="showDeleteConfirm = false"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500 transition-colors"
                >
                Cancel
                </button>
                <button
                    @click="deleteEvent"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors"
                >
                Delete
                </button>
            </div>
        </div>
    </div>
</div>
</div>
</template>
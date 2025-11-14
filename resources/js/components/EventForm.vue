<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { MapPin } from 'lucide-vue-next'
import { watch } from 'vue'

// Props to control modal visibility
const props = defineProps<{
    isOpen: boolean
    isEditing?: boolean
    event?: any
}>()

const emit = defineEmits<{
    close: []
    created: [event: any]
    updated: [event: any]
}>()

// Initialize form with event if editing
watch(() => props.event, (event) => {
    if (event) {
        form.defaults(event) // prefill form with existing event data
        form.reset(event)
    }
})

const form = useForm({
    title: '',
    description: '',
    date: '',
    time: '',
    venue: '',
    address: '',
    max_capacity: '',
    registration_fee: '',
    requires_approval: false,
})

watch(() => props.event, (event) => {
    if (event) {
        form.reset(event)
    }
})

function submit() {
    if (props.isEditing && props.event) {
        form.put(`/events/${props.event.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            emit('updated', form.data()) // just send back form data
            emit('close')
        },
        })
    } else {
        form.post('/events', {
            preserveScroll: true,
            onSuccess: () => {
                emit('created', form.data())
                emit('close')
                form.reset()
            },
        })
    }
}

function cancel() {
    emit('close')
    form.reset()
}
</script>

<template>
    <!-- Modal Overlay -->
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-slate-900 p-6 rounded-lg w-full max-w-2xl shadow-lg max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">
                    {{ isEditing ? 'Edit Event' : 'Create New Event' }}
                </h2>
                <p class="text-gray-400">
                    {{ isEditing ? 'Update the details of this event' : 'Set up a new event with all necessary details' }}
                </p>
            </div>

        <!-- Error Display -->
        <div v-if="form.errors && Object.keys(form.errors).length" class="mb-4 p-3 bg-red-900 text-red-200 rounded">
            <p class="font-semibold">Please fix the following errors:</p>
            <ul class="list-disc list-inside mt-1">
                <li v-for="(error, field) in form.errors" :key="field">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Event Details Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Event Details</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Event Title</label>
                    <input 
                        v-model="form.title" 
                        type="text" 
                        placeholder="Enter event title"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        :required="!props.isEditing"
                    />
                    <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                    <textarea 
                        v-model="form.description" 
                        rows="4"
                        placeholder="Enter event description"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                    ></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-300 mb-1">Event Date</label>
                    <input 
                        v-model="form.date" 
                        type="date" 
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        :required="!props.isEditing"
                    />
                    <div v-if="form.errors.date" class="text-red-500 text-sm mt-1">{{ form.errors.date }}</div>
                </div>

                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-300 mb-1">Event Time</label>
                        <input 
                            v-model="form.time" 
                            type="time" 
                            class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            :required="!props.isEditing"
                        />
                        <div v-if="form.errors.time" class="text-red-500 text-sm mt-1">{{ form.errors.time }}</div>
                </div>
            </div>
        </div>

            <!-- Location Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Location</h3>
            
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Venue</label>
                    <input 
                        v-model="form.venue" 
                        type="text" 
                        placeholder="Enter venue name"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        :required="!props.isEditing"
                    />
                    <div v-if="form.errors.venue" class="text-red-500 text-sm mt-1">{{ form.errors.venue }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Address</label>
                    <input 
                        v-model="form.address" 
                        type="text" 
                        placeholder="Enter full address"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                </div>

                <!-- Map Preview Placeholder -->
                <div class="bg-gray-700 border border-gray-600 rounded p-8 text-center">
                    <MapPin class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                    <p class="text-gray-400 text-sm">Map preview will appear here</p>
                </div>
            </div>

            <!-- Participant Settings Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white border-b border-gray-700 pb-2">Participant Settings</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Maximum Capacity</label>
                    <input 
                        v-model="form.max_capacity" 
                        type="number" 
                        placeholder="Enter maximum participants"
                        class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        min="1"
                    />
                        <div v-if="form.errors.max_capacity" class="text-red-500 text-sm mt-1">{{ form.errors.max_capacity }}</div>
                </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Registration Fee</label>
                <input 
                    v-model="form.registration_fee" 
                    type="number" 
                    step="0.01"
                    placeholder="Enter fee amount (optional)"
                    class="w-full bg-gray-800 text-gray-200 border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    min="0"
                />
                <div v-if="form.errors.registration_fee" class="text-red-500 text-sm mt-1">{{ form.errors.registration_fee }}</div>
            </div>

            <div class="flex items-center">
                <input 
                    v-model="form.requires_approval" 
                    type="checkbox" 
                    id="requires_approval"
                    class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2"
                />
                <label for="requires_approval" class="ml-2 text-sm text-gray-300">
                Require approval for registration
                </label>
            </div>
        </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 pt-4">
                <button
                    type="button"
                    @click="cancel"
                    class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 text-white transition-colors"
                    :disabled="form.processing"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 transition-colors"
                >
                    <span v-if="form.processing">
                        {{ isEditing ? 'Updating Event...' : 'Creating Event...' }}
                    </span>
                    <span v-else>
                        {{ isEditing ? 'Update Event' : 'Create Event' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
</template>
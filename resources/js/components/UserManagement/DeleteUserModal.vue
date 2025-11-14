<!-- /resources/components/UserManagement/DeleteUserModal.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

interface User {
    id: number
    name: string
    email: string
}

const props = defineProps<{
    user: User
}>()

const emit = defineEmits<{
    close: []
}>()

const isDeleting = ref(false)
const confirmName = ref('')
const errors = ref<Record<string, string>>({})

// Only allow delete when input matches user's name
const isConfirmValid = computed(() => confirmName.value.trim() === props.user.name)

const deleteUser = () => {
    if (!isConfirmValid.value) return
    
    isDeleting.value = true
    
    router.delete(`/users/${props.user.id}`, {
        onSuccess: () => {
            emit('close')
        },
        onError: (serverErrors) => {
            errors.value = serverErrors
        },
        onFinish: () => {
            isDeleting.value = false
        }
    })
}

const handleEscape = (event: KeyboardEvent) => {
    if (event.key === 'Escape') {
        emit('close')
    }
}

document.addEventListener('keydown', handleEscape)
</script>

<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="emit('close')">
        <div class="bg-gray-800 rounded-lg w-full max-w-lg border border-gray-700 shadow-xl">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Delete User</h3>
                <button 
                    @click="emit('close')"
                    class="text-gray-400 hover:text-white p-2 rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 
                              0 1.918-.816 1.994-1.85L21 18V6c0-1.054-.816-1.918-1.85-1.994L19 
                              4H5c-1.054 0-1.918.816-1.994 1.85L3 6v12c0 
                              1.054.816 1.918 1.85 1.994L5 20z"/>
                    </svg>
                    <div>
                        <p class="text-gray-300">
                            Are you sure you want to <span class="text-red-400 font-semibold">permanently delete</span> 
                            the user <span class="font-semibold text-white">{{ user.name }}</span>?
                        </p>
                        <p class="text-sm text-gray-400 mt-1">This action <span class="text-red-400 font-medium">cannot</span> be undone.</p>
                    </div>
                </div>

                <!-- Confirmation Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Please type <span class="text-white font-semibold">{{ user.name }}</span> to confirm:
                    </label>
                    <input
                        v-model="confirmName"
                        type="text"
                        class="w-full bg-gray-700 border rounded-lg px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 transition-colors"
                        :class="isConfirmValid ? 'border-gray-600 focus:ring-green-500' : 'border-red-500 focus:ring-red-500'"
                        placeholder="Enter user name"
                    />
                </div>

                <p v-if="errors.general" class="text-sm text-red-400">{{ errors.general }}</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-6 border-t border-gray-700">
                <button
                    type="button"
                    @click="emit('close')"
                    class="px-4 py-2 text-gray-300 hover:text-white transition-colors"
                    :disabled="isDeleting"
                >
                    Cancel
                </button>
                <button
                    @click="deleteUser"
                    class="bg-red-600 hover:bg-red-700 disabled:bg-red-800 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg flex items-center gap-2 transition-colors"
                    :disabled="isDeleting || !isConfirmValid"
                >
                    <svg v-if="isDeleting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" 
                              d="M4 12a8 8 0 018-8V0C5.373 
                              0 0 5.373 0 12h4zm2 5.291A7.962 
                              7.962 0 014 12H0c0 3.042 1.135 
                              5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ isDeleting ? 'Deleting...' : 'Delete User' }}
                </button>
            </div>
        </div>
    </div>
</template>

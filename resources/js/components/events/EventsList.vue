<script setup lang="ts">
import { ref, reactive, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Badge } from '@/components/ui/badge'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Plus, Search, Edit, Trash2, MapPin, Calendar, Users, Loader2, RotateCcw } from 'lucide-vue-next'

// Types
interface Event {
    id: number
    title: string
    description: string
    date: string
    time: string
    location: string
    capacity: number
    registered: number
    status: 'upcoming' | 'ongoing' | 'completed' | 'cancelled'
    category: string
    is_full: boolean
}

// Props
const props = defineProps<{
    events: Event[]
    filters: {
        search: string
    }
}>()

// State
const searchQuery = ref(props.filters.search)
const isDialogOpen = ref(false)
const isDeleteDialogOpen = ref(false)
const isEditing = ref(false)
const eventToDelete = ref<number | null>(null)
const isSubmitting = ref(false)

// Form state
const form = reactive({
    id: 0,
    title: '',
    description: '',
    date: '',
    time: '',
    location: '',
    capacity: 0,
    category: '',
    status: 'upcoming' as Event['status']
})

// Errors from server
const errors = computed(() => usePage().props.errors)

// Computed
const filteredEvents = computed(() => {
    if (!searchQuery.value) return props.events
    const query = searchQuery.value.toLowerCase()
    return props.events.filter(event =>
        event.title.toLowerCase().includes(query) ||
        event.location.toLowerCase().includes(query) ||
        event.category.toLowerCase().includes(query)
    )
})

// Methods
const searchEvents = () => {
    router.get('/event-management', { search: searchQuery.value }, {
        preserveState: true,
        replace: true
    })
}

const openCreateDialog = () => {
    isEditing.value = false
    resetForm()
    isDialogOpen.value = true
}

const openEditDialog = (event: Event) => {
    isEditing.value = true
    Object.assign(form, {
        id: event.id,
        title: event.title,
        description: event.description,
        date: event.date,
        time: event.time,
        location: event.location,
        capacity: event.capacity,
        category: event.category,
        status: event.status
    })
    isDialogOpen.value = true
}

const saveEvent = () => {
    isSubmitting.value = true

    const url = isEditing.value ? `/api/events/${form.id}` : '/api/events'
    const method = isEditing.value ? 'put' : 'post'

    router[method](url, form, {
        onSuccess: () => {
            isDialogOpen.value = false
            resetForm()
        },
        onError: () => {
            // Errors are handled by Inertia
        },
        onFinish: () => {
            isSubmitting.value = false
        }
    })
}

const openDeleteDialog = (id: number) => {
    eventToDelete.value = id
    isDeleteDialogOpen.value = true
}

const deleteEvent = () => {
    if (!eventToDelete.value) return

    router.delete(`/api/events/${eventToDelete.value}`, {
        onSuccess: () => {
            isDeleteDialogOpen.value = false
            eventToDelete.value = null
        }
    })
}

const resetForm = () => {
    Object.assign(form, {
        id: 0,
        title: '',
        description: '',
        date: '',
        time: '',
        location: '',
        capacity: 0,
        category: '',
        status: 'upcoming'
    })
}

const getStatusColor = (status: Event['status']) => {
    const colors = {
        upcoming: 'bg-blue-500/10 text-blue-500 hover:bg-blue-500/20',
        ongoing: 'bg-green-500/10 text-green-500 hover:bg-green-500/20',
        completed: 'bg-gray-500/10 text-gray-400 hover:bg-gray-500/20',
        cancelled: 'bg-red-500/10 text-red-500 hover:bg-red-500/20'
    }
    return colors[status]
}

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}

// Event categories
const categories = [
    'Workshop',
    'Seminar',
    'Conference',
    'Social',
    'Sports',
    'Cultural',
    'Academic',
    'Training',
    'Networking',
    'Other'
]

// Get today's date in YYYY-MM-DD format for date input min attribute
const today = new Date().toISOString().split('T')[0]
</script>

<template>
    <div class="space-y-6">
        <!-- Search and Actions Card -->
        <Card>
            <CardContent class="pt-6">
                <div class="flex items-center justify-between gap-4">
                    <div class="relative flex-1 max-w-sm">
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                        <Input
                            v-model="searchQuery"
                            placeholder="Search events by title, location, or category..."
                            class="pl-10"
                            @input="searchEvents"
                        />
                    </div>
                    <Button @click="openCreateDialog" class="gap-2">
                        <Plus class="w-4 h-4" />
                        Create Event
                    </Button>
                </div>
            </CardContent>
        </Card>

        <!-- Events Table Card -->
        <Card>
            <CardHeader>
                <CardTitle>Events</CardTitle>
                <CardDescription>
                    Manage all events in your organization. {{ filteredEvents.length }} event(s) found.
                </CardDescription>
            </CardHeader>
            <CardContent class="p-0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Event</TableHead>
                            <TableHead>Date & Time</TableHead>
                            <TableHead>Location</TableHead>
                            <TableHead>Capacity</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="event in filteredEvents" :key="event.id">
                            <TableCell>
                                <div>
                                    <div class="font-medium text-foreground">{{ event.title }}</div>
                                    <div class="text-sm text-muted-foreground">{{ event.category }}</div>
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="flex items-center gap-2 text-sm">
                                    <Calendar class="w-4 h-4 text-muted-foreground" />
                                    <span>{{ formatDate(event.date) }} at {{ event.time }}</span>
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="flex items-center gap-2 text-sm">
                                    <MapPin class="w-4 h-4 text-muted-foreground" />
                                    <span>{{ event.location }}</span>
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="flex items-center gap-2 text-sm">
                                    <Users class="w-4 h-4 text-muted-foreground" />
                                    <span :class="{ 'text-red-500 font-medium': event.is_full }">
                                        {{ event.registered }}/{{ event.capacity }}
                                        <span v-if="event.is_full" class="text-xs">(Full)</span>
                                    </span>
                                </div>
                            </TableCell>
                            <TableCell>
                                <Badge :class="getStatusColor(event.status)" class="capitalize">
                                    {{ event.status }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        @click="openEditDialog(event)"
                                    >
                                        <Edit class="w-4 h-4" />
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        @click="openDeleteDialog(event.id)"
                                    >
                                        <Trash2 class="w-4 h-4 text-destructive" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="filteredEvents.length === 0">
                            <TableCell colspan="6" class="text-center py-8 text-muted-foreground">
                                <div class="flex flex-col items-center gap-2">
                                    <Calendar class="w-8 h-8" />
                                    <span>No events found.</span>
                                    <Button @click="openCreateDialog" variant="outline" class="mt-2">
                                        Create your first event
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>

        <!-- Create/Edit Dialog -->
        <Dialog v-model:open="isDialogOpen">
            <DialogContent class="max-w-2xl max-h-[90vh] overflow-y-auto">
                <DialogHeader>
                    <DialogTitle>{{ isEditing ? 'Edit Event' : 'Create New Event' }}</DialogTitle>
                    <DialogDescription>
                        {{ isEditing ? 'Update the event details below' : 'Fill in the details to create a new event' }}
                    </DialogDescription>
                </DialogHeader>
                
                <form @submit.prevent="saveEvent" class="space-y-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div class="grid gap-2">
                            <Label for="title">
                                Event Title <span class="text-destructive">*</span>
                            </Label>
                            <Input 
                                id="title" 
                                v-model="form.title" 
                                placeholder="Enter event title" 
                                :class="errors.title ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.title" class="text-sm text-destructive">{{ errors.title }}</p>
                        </div>
                        
                        <div class="grid gap-2">
                            <Label for="description">
                                Description <span class="text-destructive">*</span>
                            </Label>
                            <Textarea 
                                id="description" 
                                v-model="form.description" 
                                placeholder="Enter event description" 
                                rows="3" 
                                :class="errors.description ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.description" class="text-sm text-destructive">{{ errors.description }}</p>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="date">
                                Date <span class="text-destructive">*</span>
                            </Label>
                            <Input 
                                id="date" 
                                v-model="form.date" 
                                type="date"
                                :min="today"
                                :class="errors.date ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.date" class="text-sm text-destructive">{{ errors.date }}</p>
                        </div>
                        <div class="grid gap-2">
                            <Label for="time">
                                Time <span class="text-destructive">*</span>
                            </Label>
                            <Input 
                                id="time" 
                                v-model="form.time" 
                                type="time" 
                                :class="errors.time ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.time" class="text-sm text-destructive">{{ errors.time }}</p>
                        </div>
                    </div>

                    <!-- Location & Category -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="location">
                                Location <span class="text-destructive">*</span>
                            </Label>
                            <Input 
                                id="location" 
                                v-model="form.location" 
                                placeholder="Enter event location" 
                                :class="errors.location ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.location" class="text-sm text-destructive">{{ errors.location }}</p>
                        </div>
                        <div class="grid gap-2">
                            <Label for="category">
                                Category <span class="text-destructive">*</span>
                            </Label>
                            <Select v-model="form.category">
                                <SelectTrigger :class="errors.category ? 'border-destructive' : ''">
                                    <SelectValue placeholder="Select category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem 
                                        v-for="category in categories" 
                                        :key="category" 
                                        :value="category"
                                    >
                                        {{ category }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="errors.category" class="text-sm text-destructive">{{ errors.category }}</p>
                        </div>
                    </div>

                    <!-- Capacity & Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="capacity">
                                Capacity <span class="text-destructive">*</span>
                            </Label>
                            <Input 
                                id="capacity" 
                                v-model.number="form.capacity" 
                                type="number" 
                                placeholder="Max attendees" 
                                min="1" 
                                :class="errors.capacity ? 'border-destructive' : ''"
                            />
                            <p v-if="errors.capacity" class="text-sm text-destructive">{{ errors.capacity }}</p>
                        </div>
                        <div class="grid gap-2">
                            <Label for="status">Status</Label>
                            <Select v-model="form.status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="upcoming">Upcoming</SelectItem>
                                    <SelectItem value="ongoing">Ongoing</SelectItem>
                                    <SelectItem value="completed">Completed</SelectItem>
                                    <SelectItem value="cancelled">Cancelled</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <DialogFooter class="gap-3 pt-4 border-t">
                        <Button
                            type="button"
                            @click="resetForm"
                            variant="outline"
                            class="gap-2"
                            :disabled="isSubmitting"
                        >
                            <RotateCcw class="h-4 w-4" />
                            Reset Form
                        </Button>
                        <Button
                            type="button"
                            variant="outline"
                            @click="isDialogOpen = false"
                            :disabled="isSubmitting"
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            class="gap-2"
                            :disabled="isSubmitting"
                        >
                            <Loader2 v-if="isSubmitting" class="h-4 w-4 animate-spin" />
                            <Plus v-else class="h-4 w-4" />
                            {{ isSubmitting ? 'Saving...' : (isEditing ? 'Update' : 'Create') }} Event
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Delete Confirmation Dialog -->
        <AlertDialog v-model:open="isDeleteDialogOpen">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This action cannot be undone. This will permanently delete the event
                        and all associated data including attendee registrations.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="deleteEvent" class="bg-destructive hover:bg-destructive/90">
                        Delete Event
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
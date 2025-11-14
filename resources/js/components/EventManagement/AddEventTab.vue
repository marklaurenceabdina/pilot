<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Calendar, MapPin, Users, Tag, Loader2, RotateCcw, Plus, AlertTriangle } from 'lucide-vue-next'

const emit = defineEmits<{
    eventCreated: []
}>()

// Form state
const form = reactive({
    title: '',
    description: '',
    date: '',
    time: '',
    location: '',
    capacity: 0,
    category: '',
    status: 'upcoming' as 'upcoming' | 'ongoing' | 'completed' | 'cancelled'
})

const isSubmitting = ref(false)
const errors = ref<Record<string, string>>({})

// Form validation
const validateForm = () => {
    errors.value = {}
    
    if (!form.title.trim()) {
        errors.value.title = 'Event title is required'
    }
    
    if (!form.description.trim()) {
        errors.value.description = 'Event description is required'
    }
    
    if (!form.date) {
        errors.value.date = 'Event date is required'
    } else {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (new Date(form.date) < today) {
            errors.value.date = 'Event date cannot be in the past';
        }
    }
    
    if (!form.time) {
        errors.value.time = 'Event time is required'
    }
    
    if (!form.location.trim()) {
        errors.value.location = 'Event location is required'
    }
    
    if (!form.capacity || form.capacity < 1) {
        errors.value.capacity = 'Capacity must be at least 1'
    }
    
    if (!form.category.trim()) {
        errors.value.category = 'Event category is required'
    }
    
    return Object.keys(errors.value).length === 0
}

// Submit form
const submitForm = () => {
    if (!validateForm()) return
    
    isSubmitting.value = true
    
    router.post('/events', form, {
        onSuccess: () => {
            resetForm()
            emit('eventCreated')
        },
        onError: (serverErrors) => {
            errors.value = serverErrors
        },
        onFinish: () => {
            isSubmitting.value = false
        }
    })
}

// Reset form
const resetForm = () => {
    Object.assign(form, {
        title: '',
        description: '',
        date: '',
        time: '',
        location: '',
        capacity: 0,
        category: '',
        status: 'upcoming'
    })
    errors.value = {}
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
    <div class="max-w-2xl mx-auto">
        <Card>
            <CardHeader>
                <CardTitle>Create New Event</CardTitle>
                <CardDescription>Fill in the details to create a new event for your organization</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <Calendar class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Event Information</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Title -->
                            <div class="space-y-2">
                                <Label for="title">
                                    Event Title <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    placeholder="Enter event title"
                                    :class="errors.title ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.title" class="text-sm text-destructive">{{ errors.title }}</p>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <Label for="description">
                                    Description <span class="text-destructive">*</span>
                                </Label>
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    placeholder="Enter event description"
                                    rows="4"
                                    :class="errors.description ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.description" class="text-sm text-destructive">{{ errors.description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Time Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <Calendar class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Date & Time</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Date -->
                            <div class="space-y-2">
                                <Label for="date">
                                    Event Date <span class="text-destructive">*</span>
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

                            <!-- Time -->
                            <div class="space-y-2">
                                <Label for="time">
                                    Event Time <span class="text-destructive">*</span>
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
                    </div>

                    <!-- Location & Capacity Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <MapPin class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Location & Capacity</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Location -->
                            <div class="space-y-2">
                                <Label for="location">
                                    Location <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="location"
                                    v-model="form.location"
                                    type="text"
                                    placeholder="Enter event location"
                                    :class="errors.location ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.location" class="text-sm text-destructive">{{ errors.location }}</p>
                            </div>

                            <!-- Capacity -->
                            <div class="space-y-2">
                                <Label for="capacity">
                                    Capacity <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="capacity"
                                    v-model.number="form.capacity"
                                    type="number"
                                    placeholder="Maximum attendees"
                                    min="1"
                                    :class="errors.capacity ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.capacity" class="text-sm text-destructive">{{ errors.capacity }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Category & Status Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <Tag class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Category & Status</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Category -->
                            <div class="space-y-2">
                                <Label for="category">
                                    Category <span class="text-destructive">*</span>
                                </Label>
                                <Select v-model="form.category">
                                    <SelectTrigger :class="errors.category ? 'border-destructive' : ''">
                                        <SelectValue placeholder="Select Category" />
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

                            <!-- Status -->
                            <div class="space-y-2">
                                <Label for="status">Status</Label>
                                <Select v-model="form.status">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="upcoming">Upcoming</SelectItem>
                                        <SelectItem value="ongoing">Ongoing</SelectItem>
                                        <SelectItem value="completed">Completed</SelectItem>
                                        <SelectItem value="cancelled">Cancelled</SelectItem>
                                    </SelectContent>
                                </Select>
                                <p class="text-sm text-muted-foreground">
                                    Default status is "Upcoming"
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notice -->
                    <Alert class="bg-warning/20 border-warning">
                        <AlertTriangle class="h-4 w-4 text-warning-foreground" />
                        <AlertDescription class="text-warning-foreground">
                            <strong>Important:</strong> Once created, events can be managed from the Event List tab. 
                            Attendee registrations will be tracked automatically.
                        </AlertDescription>
                    </Alert>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 pt-6 border-t">
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
                            type="submit"
                            class="gap-2"
                            :disabled="isSubmitting"
                        >
                            <Loader2 v-if="isSubmitting" class="h-4 w-4 animate-spin" />
                            <Plus v-else class="h-4 w-4" />
                            {{ isSubmitting ? 'Creating Event...' : 'Create Event' }}
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
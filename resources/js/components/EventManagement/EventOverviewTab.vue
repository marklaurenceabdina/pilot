<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Calendar, Users, CheckCircle, XCircle, Clock, AlertCircle } from 'lucide-vue-next'

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

interface Props {
    events: Event[]
    stats: {
        total: number
        upcoming: number
        ongoing: number
        completed: number
        cancelled: number
        full: number
    }
}

defineProps<Props>()

const emit = defineEmits<{
    switchToEvents: []
    switchToAdd: []
}>()

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}
</script>

<template>
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Events</CardTitle>
                    <Calendar class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.total }}</div>
                    <p class="text-xs text-muted-foreground">All events created</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Upcoming</CardTitle>
                    <Clock class="h-4 w-4 text-blue-500" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold text-blue-500">{{ stats.upcoming }}</div>
                    <p class="text-xs text-muted-foreground">Scheduled events</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Ongoing</CardTitle>
                    <Users class="h-4 w-4 text-green-500" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold text-green-500">{{ stats.ongoing }}</div>
                    <p class="text-xs text-muted-foreground">Currently active</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Full Events</CardTitle>
                    <AlertCircle class="h-4 w-4 text-orange-500" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold text-orange-500">{{ stats.full }}</div>
                    <p class="text-xs text-muted-foreground">At capacity</p>
                </CardContent>
            </Card>
        </div>

        <!-- Quick Actions -->
        <Card>
            <CardHeader>
                <CardTitle>Quick Actions</CardTitle>
                <CardDescription>Manage your events efficiently</CardDescription>
            </CardHeader>
            <CardContent class="flex gap-4">
                <Button @click="emit('switchToAdd')" class="gap-2">
                    <Users class="w-4 h-4" />
                    Create New Event
                </Button>
                <Button @click="emit('switchToEvents')" variant="outline" class="gap-2">
                    <Calendar class="w-4 h-4" />
                    View All Events
                </Button>
            </CardContent>
        </Card>

        <!-- Recent Events -->
        <Card>
            <CardHeader>
                <CardTitle>Recent Events</CardTitle>
                <CardDescription>Latest events created in the system</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div 
                        v-for="event in events.slice(0, 5)" 
                        :key="event.id"
                        class="flex items-center justify-between p-4 border rounded-lg"
                    >
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <Calendar class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-foreground">{{ event.title }}</h4>
                                <p class="text-sm text-muted-foreground">
                                    {{ formatDate(event.date) }} • {{ event.location }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-foreground">
                                {{ event.registered }}/{{ event.capacity }}
                            </div>
                            <div class="text-xs text-muted-foreground capitalize">
                                {{ event.status }}
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="events.length === 0" class="text-center py-8 text-muted-foreground">
                        <Calendar class="w-12 h-12 mx-auto mb-4 opacity-50" />
                        <p>No events found. Create your first event to get started.</p>
                        <Button @click="emit('switchToAdd')" variant="outline" class="mt-4">
                            Create Event
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
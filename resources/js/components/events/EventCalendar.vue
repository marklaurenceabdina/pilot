<script setup lang="ts">
import { ref, computed } from 'vue'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { ChevronLeft, ChevronRight, Calendar, MapPin, Users } from 'lucide-vue-next'

interface Event {
    id: number
    title: string
    date: string
    time: string
    location: string
    capacity: number
    registered: number
    status: 'upcoming' | 'ongoing' | 'completed' | 'cancelled'
    category: string
}

// Sample events
const events: Event[] = [
    {
        id: 1,
        title: 'Web Development Workshop',
        date: '2025-10-15',
        time: '14:00',
        location: 'Computer Lab 1',
        capacity: 50,
        registered: 35,
        status: 'upcoming',
        category: 'Workshop'
    },
    {
        id: 2,
        title: 'Annual Tech Conference',
        date: '2025-11-20',
        time: '09:00',
        location: 'Main Auditorium',
        capacity: 200,
        registered: 150,
        status: 'upcoming',
        category: 'Conference'
    },
    {
        id: 3,
        title: 'Python Programming 101',
        date: '2025-10-18',
        time: '10:00',
        location: 'Room 305',
        capacity: 30,
        registered: 28,
        status: 'upcoming',
        category: 'Workshop'
    },
    {
        id: 4,
        title: 'Hackathon 2025',
        date: '2025-10-25',
        time: '08:00',
        location: 'Innovation Hub',
        capacity: 100,
        registered: 85,
        status: 'upcoming',
        category: 'Competition'
    }
]

const currentDate = ref(new Date())
const selectedDate = ref<Date | null>(null)

const monthYear = computed(() => {
    return currentDate.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
})

const daysInMonth = computed(() => {
    const year = currentDate.value.getFullYear()
    const month = currentDate.value.getMonth()
    const firstDay = new Date(year, month, 1)
    const lastDay = new Date(year, month + 1, 0)
    
    const days = []
    const startDay = firstDay.getDay()
    
    // Add empty cells for days before month starts
    for (let i = 0; i < startDay; i++) {
        days.push(null)
    }
    
    // Add all days in month
    for (let i = 1; i <= lastDay.getDate(); i++) {
        days.push(new Date(year, month, i))
    }
    
    return days
})

const getEventsForDate = (date: Date | null) => {
    if (!date) return []
    const dateStr = date.toISOString().split('T')[0]
    return events.filter(event => event.date === dateStr)
}

const selectedDateEvents = computed(() => {
    return selectedDate.value ? getEventsForDate(selectedDate.value) : []
})

const isToday = (date: Date | null) => {
    if (!date) return false
    const today = new Date()
    return date.toDateString() === today.toDateString()
}

const isSelected = (date: Date | null) => {
    if (!date || !selectedDate.value) return false
    return date.toDateString() === selectedDate.value.toDateString()
}

const hasEvents = (date: Date | null) => {
    return date && getEventsForDate(date).length > 0
}

const previousMonth = () => {
    currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() - 1)
}

const nextMonth = () => {
    currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1)
}

const selectDate = (date: Date | null) => {
    if (date) {
        selectedDate.value = date
    }
}

const getStatusColor = (status: string) => {
    const colors = {
        upcoming: 'bg-blue-500/10 text-blue-500',
        ongoing: 'bg-green-500/10 text-green-500',
        completed: 'bg-gray-500/10 text-gray-400',
        cancelled: 'bg-red-500/10 text-red-500'
    }
    return colors[status as keyof typeof colors] || colors.upcoming
}
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar -->
        <Card class="lg:col-span-2">
            <CardHeader>
                <div class="flex items-center justify-between">
                    <CardTitle>{{ monthYear }}</CardTitle>
                    <div class="flex gap-2">
                        <Button variant="outline" size="icon" @click="previousMonth">
                            <ChevronLeft class="w-4 h-4" />
                        </Button>
                        <Button variant="outline" size="icon" @click="nextMonth">
                            <ChevronRight class="w-4 h-4" />
                        </Button>
                    </div>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2">
                    <!-- Day headers -->
                    <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" :key="day"
                        class="text-center text-sm font-medium text-muted-foreground py-2">
                        {{ day }}
                    </div>
                    
                    <!-- Calendar days -->
                    <button
                        v-for="(date, index) in daysInMonth"
                        :key="index"
                        @click="selectDate(date)"
                        :disabled="!date"
                        class="aspect-square p-2 relative rounded-md transition-colors"
                        :class="[
                            date ? 'hover:bg-accent cursor-pointer' : 'cursor-default',
                            isToday(date) && 'bg-primary/10 text-primary font-semibold',
                            isSelected(date) && 'bg-primary text-primary-foreground hover:bg-primary',
                            !date && 'invisible'
                        ]"
                    >
                        <span v-if="date" class="text-sm">{{ date.getDate() }}</span>
                        <div v-if="hasEvents(date)" class="absolute bottom-1 left-1/2 transform -translate-x-1/2">
                            <div class="w-1 h-1 rounded-full bg-blue-500"></div>
                        </div>
                    </button>
                </div>
            </CardContent>
        </Card>

        <!-- Selected Date Events -->
        <Card>
            <CardHeader>
                <CardTitle class="flex items-center gap-2">
                    <Calendar class="w-5 h-5" />
                    Events
                </CardTitle>
                <CardDescription>
                    {{ selectedDate ? selectedDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : 'Select a date to view events' }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div v-if="selectedDateEvents.length > 0" class="space-y-3">
                    <div
                        v-for="event in selectedDateEvents"
                        :key="event.id"
                        class="p-4 rounded-lg border bg-card hover:bg-accent/50 transition-colors"
                    >
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="font-semibold text-sm leading-tight">{{ event.title }}</h4>
                                <Badge :class="getStatusColor(event.status)" class="text-xs capitalize shrink-0">
                                    {{ event.status }}
                                </Badge>
                            </div>
                            <div class="space-y-1 text-xs text-muted-foreground">
                                <div class="flex items-center gap-2">
                                    <Calendar class="w-3 h-3" />
                                    <span>{{ event.time }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <MapPin class="w-3 h-3" />
                                    <span>{{ event.location }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Users class="w-3 h-3" />
                                    <span>{{ event.registered }}/{{ event.capacity }} registered</span>
                                </div>
                            </div>
                            <Badge variant="outline" class="text-xs">{{ event.category }}</Badge>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-8 text-muted-foreground">
                    <Calendar class="w-12 h-12 mx-auto mb-3 opacity-20" />
                    <p class="text-sm">{{ selectedDate ? 'No events scheduled' : 'Select a date to view events' }}</p>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
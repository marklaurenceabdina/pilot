<script setup lang="ts">
import { ref, computed } from 'vue'
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
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Label } from '@/components/ui/label'
import { Badge } from '@/components/ui/badge'
import { Avatar, AvatarFallback } from '@/components/ui/avatar'
import { Search, UserPlus, Mail, Phone, CheckCircle2, XCircle, Clock } from 'lucide-vue-next'

interface Attendee {
    id: number
    name: string
    email: string
    phone: string
    event: string
    eventId: number
    registrationDate: string
    status: 'confirmed' | 'pending' | 'cancelled'
    paymentStatus: 'paid' | 'unpaid' | 'refunded'
}

// Sample data
const attendees = ref<Attendee[]>([
    {
        id: 1,
        name: 'John Doe',
        email: 'john.doe@email.com',
        phone: '+63 912 345 6789',
        event: 'Web Development Workshop',
        eventId: 1,
        registrationDate: '2025-09-15',
        status: 'confirmed',
        paymentStatus: 'paid'
    },
    {
        id: 2,
        name: 'Jane Smith',
        email: 'jane.smith@email.com',
        phone: '+63 923 456 7890',
        event: 'Annual Tech Conference',
        eventId: 2,
        registrationDate: '2025-09-20',
        status: 'confirmed',
        paymentStatus: 'paid'
    },
    {
        id: 3,
        name: 'Mike Johnson',
        email: 'mike.j@email.com',
        phone: '+63 934 567 8901',
        event: 'Web Development Workshop',
        eventId: 1,
        registrationDate: '2025-09-18',
        status: 'pending',
        paymentStatus: 'unpaid'
    },
    {
        id: 4,
        name: 'Sarah Williams',
        email: 'sarah.w@email.com',
        phone: '+63 945 678 9012',
        event: 'Coding Bootcamp',
        eventId: 3,
        registrationDate: '2025-09-10',
        status: 'cancelled',
        paymentStatus: 'refunded'
    }
])

const events = [
    { id: 1, name: 'Web Development Workshop' },
    { id: 2, name: 'Annual Tech Conference' },
    { id: 3, name: 'Coding Bootcamp' }
]

// State
const searchQuery = ref('')
const selectedEvent = ref<number | 'all'>('all')
const isDialogOpen = ref(false)

// Form state
const form = ref({
    id: 0,
    name: '',
    email: '',
    phone: '',
    eventId: 0,
    status: 'pending' as Attendee['status'],
    paymentStatus: 'unpaid' as Attendee['paymentStatus']
})

// Computed
const filteredAttendees = computed(() => {
    let filtered = attendees.value

    if (selectedEvent.value !== 'all') {
        filtered = filtered.filter(a => a.eventId === selectedEvent.value)
    }

    if (searchQuery.value) {
        filtered = filtered.filter(a =>
            a.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            a.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            a.event.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }

    return filtered
})

const stats = computed(() => {
    const total = attendees.value.length
    const confirmed = attendees.value.filter(a => a.status === 'confirmed').length
    const pending = attendees.value.filter(a => a.status === 'pending').length
    const cancelled = attendees.value.filter(a => a.status === 'cancelled').length

    return { total, confirmed, pending, cancelled }
})

// Methods
const openAddDialog = () => {
    form.value = {
        id: 0,
        name: '',
        email: '',
        phone: '',
        eventId: 0,
        status: 'pending',
        paymentStatus: 'unpaid'
    }
    isDialogOpen.value = true
}

const addAttendee = () => {
    const selectedEventData = events.find(e => e.id === form.value.eventId)
    if (!selectedEventData) return

    const newAttendee: Attendee = {
        id: Math.max(...attendees.value.map(a => a.id), 0) + 1,
        name: form.value.name,
        email: form.value.email,
        phone: form.value.phone,
        event: selectedEventData.name,
        eventId: form.value.eventId,
        registrationDate: new Date().toISOString().split('T')[0],
        status: form.value.status,
        paymentStatus: form.value.paymentStatus
    }

    attendees.value.push(newAttendee)
    isDialogOpen.value = false
}

const updateStatus = (id: number, status: Attendee['status']) => {
    const attendee = attendees.value.find(a => a.id === id)
    if (attendee) {
        attendee.status = status
    }
}

const getStatusIcon = (status: Attendee['status']) => {
    const icons = {
        confirmed: CheckCircle2,
        pending: Clock,
        cancelled: XCircle
    }
    return icons[status]
}

const getStatusColor = (status: Attendee['status']) => {
    const colors = {
        confirmed: 'bg-green-500/10 text-green-500 hover:bg-green-500/20',
        pending: 'bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20',
        cancelled: 'bg-red-500/10 text-red-500 hover:bg-red-500/20'
    }
    return colors[status]
}

const getPaymentStatusColor = (status: Attendee['paymentStatus']) => {
    const colors = {
        paid: 'bg-green-500/10 text-green-500',
        unpaid: 'bg-yellow-500/10 text-yellow-500',
        refunded: 'bg-gray-500/10 text-gray-400'
    }
    return colors[status]
}

const getInitials = (name: string) => {
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
}

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
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-lg border bg-card">
                <div class="text-sm text-muted-foreground mb-1">Total Attendees</div>
                <div class="text-2xl font-bold">{{ stats.total }}</div>
            </div>
            <div class="p-4 rounded-lg border bg-card">
                <div class="text-sm text-muted-foreground mb-1">Confirmed</div>
                <div class="text-2xl font-bold text-green-500">{{ stats.confirmed }}</div>
            </div>
            <div class="p-4 rounded-lg border bg-card">
                <div class="text-sm text-muted-foreground mb-1">Pending</div>
                <div class="text-2xl font-bold text-yellow-500">{{ stats.pending }}</div>
            </div>
            <div class="p-4 rounded-lg border bg-card">
                <div class="text-sm text-muted-foreground mb-1">Cancelled</div>
                <div class="text-2xl font-bold text-red-500">{{ stats.cancelled }}</div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:flex-initial w-full sm:w-64">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                    <Input
                        v-model="searchQuery"
                        placeholder="Search attendees..."
                        class="pl-10"
                    />
                </div>
                <Select v-model="selectedEvent">
                    <SelectTrigger class="w-full sm:w-48">
                        <SelectValue placeholder="All Events" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="all">All Events</SelectItem>
                        <SelectItem v-for="event in events" :key="event.id" :value="event.id.toString()">
                            {{ event.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <Button @click="openAddDialog" class="gap-2 w-full sm:w-auto">
                <UserPlus class="w-4 h-4" />
                Add Attendee
            </Button>
        </div>

        <!-- Attendees Table -->
        <div class="border rounded-lg bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Attendee</TableHead>
                        <TableHead>Contact</TableHead>
                        <TableHead>Event</TableHead>
                        <TableHead>Registration Date</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Payment</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="attendee in filteredAttendees" :key="attendee.id">
                        <TableCell>
                            <div class="flex items-center gap-3">
                                <Avatar>
                                    <AvatarFallback>{{ getInitials(attendee.name) }}</AvatarFallback>
                                </Avatar>
                                <div class="font-medium">{{ attendee.name }}</div>
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="space-y-1 text-sm">
                                <div class="flex items-center gap-2 text-muted-foreground">
                                    <Mail class="w-3 h-3" />
                                    <span>{{ attendee.email }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-muted-foreground">
                                    <Phone class="w-3 h-3" />
                                    <span>{{ attendee.phone }}</span>
                                </div>
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="text-sm">{{ attendee.event }}</div>
                        </TableCell>
                        <TableCell>
                            <div class="text-sm">{{ formatDate(attendee.registrationDate) }}</div>
                        </TableCell>
                        <TableCell>
                            <Badge :class="getStatusColor(attendee.status)" class="capitalize gap-1">
                                <component :is="getStatusIcon(attendee.status)" class="w-3 h-3" />
                                {{ attendee.status }}
                            </Badge>
                        </TableCell>
                        <TableCell>
                            <Badge :class="getPaymentStatusColor(attendee.paymentStatus)" class="capitalize">
                                {{ attendee.paymentStatus }}
                            </Badge>
                        </TableCell>
                        <TableCell class="text-right">
                            <Select
                                :model-value="attendee.status"
                                @update:model-value="(value) => updateStatus(attendee.id, value as Attendee['status'])"
                            >
                                <SelectTrigger class="w-32">
                                    <SelectValue />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="confirmed">Confirm</SelectItem>
                                    <SelectItem value="pending">Pending</SelectItem>
                                    <SelectItem value="cancelled">Cancel</SelectItem>
                                </SelectContent>
                            </Select>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Add Attendee Dialog -->
        <Dialog v-model:open="isDialogOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Add New Attendee</DialogTitle>
                    <DialogDescription>
                        Register a new attendee for an event
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div class="grid gap-2">
                        <Label for="name">Full Name</Label>
                        <Input id="name" v-model="form.name" placeholder="Enter full name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" v-model="form.email" type="email" placeholder="email@example.com" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="phone">Phone Number</Label>
                        <Input id="phone" v-model="form.phone" placeholder="+63 912 345 6789" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="event">Event</Label>
                        <Select v-model="form.eventId">
                            <SelectTrigger>
                                <SelectValue placeholder="Select event" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="event in events" :key="event.id" :value="event.id.toString()">
                                    {{ event.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="status">Status</Label>
                            <Select v-model="form.status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="confirmed">Confirmed</SelectItem>
                                    <SelectItem value="pending">Pending</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div class="grid gap-2">
                            <Label for="payment">Payment Status</Label>
                            <Select v-model="form.paymentStatus">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select payment" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="paid">Paid</SelectItem>
                                    <SelectItem value="unpaid">Unpaid</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </div>
                <DialogFooter>
                    <Button variant="outline" @click="isDialogOpen = false">Cancel</Button>
                    <Button @click="addAttendee">Add Attendee</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
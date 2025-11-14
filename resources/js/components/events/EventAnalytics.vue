<script setup lang="ts">
import { ref, computed } from 'vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import {
    TrendingUp,
    TrendingDown,
    Users,
    Calendar,
    DollarSign,
    BarChart3,
    Activity,
    Download,
    PieChart
} from 'lucide-vue-next'

interface EventStats {
    id: number
    name: string
    category: string
    totalAttendees: number
    capacity: number
    revenue: number
    registrationTrend: number
    status: string
}

const selectedPeriod = ref('month')

const eventStats: EventStats[] = [
    {
        id: 1,
        name: 'Web Development Workshop',
        category: 'Workshop',
        totalAttendees: 35,
        capacity: 50,
        revenue: 17500,
        registrationTrend: 12,
        status: 'upcoming'
    },
    {
        id: 2,
        name: 'Annual Tech Conference',
        category: 'Conference',
        totalAttendees: 150,
        capacity: 200,
        revenue: 75000,
        registrationTrend: 25,
        status: 'upcoming'
    },
    {
        id: 3,
        name: 'Coding Bootcamp',
        category: 'Training',
        totalAttendees: 30,
        capacity: 30,
        revenue: 45000,
        registrationTrend: -5,
        status: 'completed'
    },
    {
        id: 4,
        name: 'Python Programming 101',
        category: 'Workshop',
        totalAttendees: 28,
        capacity: 30,
        revenue: 14000,
        registrationTrend: 8,
        status: 'upcoming'
    }
]

const overallStats = computed(() => {
    const total = eventStats.reduce((sum, e) => sum + e.totalAttendees, 0)
    const totalCapacity = eventStats.reduce((sum, e) => sum + e.capacity, 0)
    const totalRevenue = eventStats.reduce((sum, e) => sum + e.revenue, 0)
    const avgOccupancy = (total / totalCapacity) * 100

    return {
        totalAttendees: total,
        totalEvents: eventStats.length,
        totalRevenue,
        avgOccupancy: avgOccupancy.toFixed(1)
    }
})

const categoryBreakdown = computed(() => {
    const breakdown: Record<string, number> = {}
    eventStats.forEach(event => {
        breakdown[event.category] = (breakdown[event.category] || 0) + event.totalAttendees
    })
    return Object.entries(breakdown).map(([name, value]) => ({ name, value }))
})

const getOccupancyPercentage = (attendees: number, capacity: number) => {
    return ((attendees / capacity) * 100).toFixed(0)
}

const getOccupancyColor = (percentage: number) => {
    if (percentage >= 90) return 'text-green-500'
    if (percentage >= 70) return 'text-yellow-500'
    return 'text-red-500'
}

const getTrendIcon = (trend: number) => {
    return trend >= 0 ? TrendingUp : TrendingDown
}

const getTrendColor = (trend: number) => {
    return trend >= 0 ? 'text-green-500' : 'text-red-500'
}

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
}

const exportAnalytics = () => {
    // In a real app, this would trigger a file download
    console.log('Exporting analytics data...')
    // You would typically make an API call here to generate and download the report
    alert('Export functionality would be implemented here')
}
</script>

<template>
    <div class="space-y-6">
        <!-- Period Selector and Actions -->
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Event Analytics</h2>
            <div class="flex items-center gap-3">
                <Select v-model="selectedPeriod">
                    <SelectTrigger class="w-40">
                        <SelectValue placeholder="Select period" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="week">This Week</SelectItem>
                        <SelectItem value="month">This Month</SelectItem>
                        <SelectItem value="quarter">This Quarter</SelectItem>
                        <SelectItem value="year">This Year</SelectItem>
                    </SelectContent>
                </Select>
                <button
                    @click="exportAnalytics"
                    class="flex items-center gap-2 px-3 py-2 text-sm border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md transition-colors"
                >
                    <Download class="w-4 h-4" />
                    Export
                </button>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <Card>
                <CardHeader class="pb-2">
                    <CardDescription class="flex items-center gap-2">
                        <Users class="w-4 h-4" />
                        Total Attendees
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold">{{ overallStats.totalAttendees }}</div>
                    <div class="flex items-center gap-1 text-sm text-green-500 mt-1">
                        <TrendingUp class="w-4 h-4" />
                        <span>+15% from last period</span>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardDescription class="flex items-center gap-2">
                        <Calendar class="w-4 h-4" />
                        Total Events
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold">{{ overallStats.totalEvents }}</div>
                    <div class="flex items-center gap-1 text-sm text-green-500 mt-1">
                        <TrendingUp class="w-4 h-4" />
                        <span>+2 from last period</span>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardDescription class="flex items-center gap-2">
                        <DollarSign class="w-4 h-4" />
                        Total Revenue
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold">{{ formatCurrency(overallStats.totalRevenue) }}</div>
                    <div class="flex items-center gap-1 text-sm text-green-500 mt-1">
                        <TrendingUp class="w-4 h-4" />
                        <span>+22% from last period</span>
                    </div>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardDescription class="flex items-center gap-2">
                        <Activity class="w-4 h-4" />
                        Avg Occupancy
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="text-3xl font-bold">{{ overallStats.avgOccupancy }}%</div>
                    <div class="flex items-center gap-1 text-sm text-yellow-500 mt-1">
                        <TrendingDown class="w-4 h-4" />
                        <span>-3% from last period</span>
                    </div>
                </CardContent>
            </Card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Event Performance -->
            <div class="lg:col-span-2">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <BarChart3 class="w-5 h-5" />
                            Event Performance
                        </CardTitle>
                        <CardDescription>Detailed breakdown of each event</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="event in eventStats"
                                :key="event.id"
                                class="p-4 rounded-lg border bg-card/50 hover:bg-accent/50 transition-colors"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-semibold">{{ event.name }}</h4>
                                        <Badge variant="outline" class="mt-1 text-xs">{{ event.category }}</Badge>
                                    </div>
                                    <Badge
                                        variant="outline"
                                        :class="[
                                            event.status === 'upcoming' && 'text-blue-500',
                                            event.status === 'completed' && 'text-gray-400'
                                        ]"
                                        class="capitalize"
                                    >
                                        {{ event.status }}
                                    </Badge>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Attendees -->
                                    <div>
                                        <div class="text-sm text-muted-foreground mb-1">Attendees</div>
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-bold">{{ event.totalAttendees }}</span>
                                            <span class="text-sm text-muted-foreground">/ {{ event.capacity }}</span>
                                        </div>
                                    </div>

                                    <!-- Occupancy -->
                                    <div>
                                        <div class="text-sm text-muted-foreground mb-1">Occupancy</div>
                                        <div class="text-2xl font-bold" :class="getOccupancyColor(Number(getOccupancyPercentage(event.totalAttendees, event.capacity)))">
                                            {{ getOccupancyPercentage(event.totalAttendees, event.capacity) }}%
                                        </div>
                                    </div>

                                    <!-- Revenue -->
                                    <div>
                                        <div class="text-sm text-muted-foreground mb-1">Revenue</div>
                                        <div class="text-2xl font-bold">{{ formatCurrency(event.revenue) }}</div>
                                    </div>

                                    <!-- Registration Trend -->
                                    <div>
                                        <div class="text-sm text-muted-foreground mb-1">Registration Trend</div>
                                        <div class="flex items-center gap-1">
                                            <component 
                                                :is="getTrendIcon(event.registrationTrend)" 
                                                class="w-4 h-4" 
                                                :class="getTrendColor(event.registrationTrend)" 
                                            />
                                            <span class="text-lg font-bold" :class="getTrendColor(event.registrationTrend)">
                                                {{ event.registrationTrend > 0 ? '+' : '' }}{{ event.registrationTrend }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mt-3">
                                    <div class="flex justify-between text-sm text-muted-foreground mb-1">
                                        <span>Capacity</span>
                                        <span>{{ getOccupancyPercentage(event.totalAttendees, event.capacity) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div 
                                            class="h-2 rounded-full transition-all duration-300"
                                            :class="[
                                                Number(getOccupancyPercentage(event.totalAttendees, event.capacity)) >= 90 ? 'bg-green-500':
                                                Number(getOccupancyPercentage(event.totalAttendees, event.capacity)) >= 70 ? 'bg-yellow-500':
                                                'bg-red-500'
                                            ]"
                                            :style="{ width: `${getOccupancyPercentage(event.totalAttendees, event.capacity)}%` }"
                                        ></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Category Breakdown -->
            <div class="lg:col-span-1">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <PieChart class="w-5 h-5" />
                            Category Breakdown
                        </CardTitle>
                        <CardDescription>Attendees by event category</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="category in categoryBreakdown"
                                :key="category.name"
                                class="flex items-center justify-between p-3 rounded-lg border bg-card/50"
                            >
                                <div class="flex items-center gap-3">
                                    <div 
                                        class="w-3 h-3 rounded-full"
                                        :class="[
                                            category.name === 'Workshop' && 'bg-blue-500',
                                            category.name === 'Conference' && 'bg-green-500',
                                            category.name === 'Training' && 'bg-purple-500'
                                        ]"
                                    ></div>
                                    <span class="font-medium">{{ category.name }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold">{{ category.value }}</div>
                                    <div class="text-sm text-muted-foreground">
                                        {{ ((category.value / overallStats.totalAttendees) * 100).toFixed(1) }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Stats -->
                        <div class="mt-6 p-4 bg-muted/50 rounded-lg">
                            <h4 class="font-semibold mb-3">Quick Stats</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Highest Occupancy:</span>
                                    <span class="font-medium">100% (Coding Bootcamp)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Highest Revenue:</span>
                                    <span class="font-medium">{{ formatCurrency(75000) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-muted-foreground">Most Popular:</span>
                                    <span class="font-medium">Conference</span>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
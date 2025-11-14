<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { 
  BarChart3,
  Users,
  Calendar,
  Activity,
  CreditCard,
  PieChart,
  TrendingUp,
  Download,
  Settings,
  Clock,
  Filter,
  Eye,
  FileText,
  Mail,
  RefreshCw
} from 'lucide-vue-next'
import axios from 'axios'

const reports = ref({
  totalUsers: 0,
  activeUsers: 0,
  totalPayments: 0,
  totalRevenue: 0,
  totalEvents: 0,
  activeEvents: 0,
  totalTransactions: 0,
  approvedTransactions: 0,
})

const isLoading = ref(true)

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
  {
    title: 'Reports',
    href: '/reports',
  },
]

// Mock data for engagement metrics
const engagementData = ref({
  memberParticipation: {
    totalMembers: 150,
    activeMembers: 120,
    weeklyActive: 95,
    monthlyActive: 135
  },
  eventAttendance: {
    totalEvents: 12,
    averageAttendance: 75,
    highestAttendance: 142,
    attendanceTrend: '+12%'
  },
  platformUsage: {
    dailyActiveUsers: 85,
    sessionDuration: '24 min',
    pageViews: 1250,
    featureUsage: {
      qrPayments: 89,
      eventRegistration: 76,
      memberDirectory: 45
    }
  }
})

// Mock data for financial analytics
const financialData = ref({
  revenueStreams: [
    { name: 'Membership Fees', amount: 45000, percentage: 60 },
    { name: 'Event Fees', amount: 18000, percentage: 24 },
    { name: 'Merchandise', amount: 9000, percentage: 12 },
    { name: 'Donations', amount: 3000, percentage: 4 }
  ],
  paymentMethods: [
    { method: 'QR Code', transactions: 245, percentage: 65 },
    { method: 'Cash', transactions: 89, percentage: 24 },
    { method: 'Bank Transfer', transactions: 32, percentage: 8 },
    { method: 'Credit Card', transactions: 11, percentage: 3 }
  ],
  collectionEfficiency: {
    totalDue: 75000,
    collected: 67500,
    pending: 6000,
    overdue: 1500,
    efficiencyRate: 90
  }
})

// Report builder state
const reportBuilder = ref({
  reportName: '',
  dateRange: 'last30days',
  dataSource: '',
  visualization: '',
  schedule: 'none',
  recipients: ''
})

const fetchReports = async () => {
  try {
    isLoading.value = true
    const { data } = await axios.get(route('reports.stats'))
    reports.value = data
  } catch (error) {
    console.error('Error fetching reports:', error)
  } finally {
    isLoading.value = false
  }
}

const generateReport = () => {
  console.log('Generating report with:', reportBuilder.value)
  // Implementation for report generation
}

const scheduleReport = () => {
  console.log('Scheduling report:', reportBuilder.value)
  // Implementation for report scheduling
}

onMounted(fetchReports)
</script>

<template>
  <Head title="Reports" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-foreground flex items-center gap-2">
            <BarChart3 class="h-6 w-6 text-primary" />
            Reports & Analytics
          </h1>
          <p class="text-muted-foreground">Comprehensive insights and reporting tools</p>
        </div>

        <div class="flex items-center gap-2">
          <Button variant="outline" size="sm">
            <Download class="h-4 w-4 mr-2" />
            Export All
          </Button>
          <Button variant="outline" size="sm">
            <RefreshCw class="h-4 w-4 mr-2" />
            Refresh
          </Button>
        </div>
      </div>

      <!-- Reports Tabs -->
      <Tabs default-value="engagement" class="space-y-4">
        <TabsList class="grid w-full grid-cols-3">
          <TabsTrigger value="engagement">Engagement Metrics</TabsTrigger>
          <TabsTrigger value="financial">Financial Analytics</TabsTrigger>
          <TabsTrigger value="custom">Custom Reports</TabsTrigger>
        </TabsList>

        <!-- Engagement Metrics Tab -->
        <TabsContent value="engagement" class="space-y-6">
          <div class="grid gap-6">
            <!-- Member Participation Rates -->
            <Card>
              <CardHeader>
                <CardTitle class="flex items-center gap-2">
                  <Users class="h-5 w-5" />
                  Member Participation Rates
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div class="grid gap-4 md:grid-cols-4">
                  <div class="text-center p-4 bg-muted/20 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ engagementData.memberParticipation.totalMembers }}</p>
                    <p class="text-sm text-muted-foreground">Total Members</p>
                  </div>
                  <div class="text-center p-4 bg-muted/20 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ engagementData.memberParticipation.activeMembers }}</p>
                    <p class="text-sm text-muted-foreground">Active Members</p>
                  </div>
                  <div class="text-center p-4 bg-muted/20 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ engagementData.memberParticipation.weeklyActive }}</p>
                    <p class="text-sm text-muted-foreground">Weekly Active</p>
                  </div>
                  <div class="text-center p-4 bg-muted/20 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600">{{ engagementData.memberParticipation.monthlyActive }}</p>
                    <p class="text-sm text-muted-foreground">Monthly Active</p>
                  </div>
                </div>
                
                <div class="mt-4 space-y-3">
                  <div class="flex justify-between text-sm">
                    <span>Active Member Rate</span>
                    <span class="font-medium">{{ Math.round((engagementData.memberParticipation.activeMembers / engagementData.memberParticipation.totalMembers) * 100) }}%</span>
                  </div>
                  <div class="w-full bg-muted rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" :style="{ width: Math.round((engagementData.memberParticipation.activeMembers / engagementData.memberParticipation.totalMembers) * 100) + '%' }"></div>
                  </div>
                </div>
              </CardContent>
            </Card>

            <!-- Event Attendance & Platform Usage -->
            <div class="grid gap-6 lg:grid-cols-2">
              <!-- Event Attendance Trends -->
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center gap-2">
                    <Calendar class="h-5 w-5" />
                    Event Attendance Trends
                  </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                      <p class="text-xl font-bold text-blue-600">{{ engagementData.eventAttendance.totalEvents }}</p>
                      <p class="text-xs text-blue-700">Total Events</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg border border-green-100">
                      <p class="text-xl font-bold text-green-600">{{ engagementData.eventAttendance.averageAttendance }}</p>
                      <p class="text-xs text-green-700">Avg. Attendance</p>
                    </div>
                  </div>
                  
                  <div class="space-y-2">
                    <div class="flex justify-between items-center">
                      <span class="text-sm">Highest Attendance</span>
                      <Badge variant="secondary">{{ engagementData.eventAttendance.highestAttendance }}</Badge>
                    </div>
                    <div class="flex justify-between items-center">
                      <span class="text-sm">Attendance Growth</span>
                      <Badge variant="outline" class="text-green-600">{{ engagementData.eventAttendance.attendanceTrend }}</Badge>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <!-- Platform Usage Statistics -->
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center gap-2">
                    <Activity class="h-5 w-5" />
                    Platform Usage Statistics
                  </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                  <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 bg-muted/20 rounded-lg">
                      <p class="text-lg font-bold">{{ engagementData.platformUsage.dailyActiveUsers }}</p>
                      <p class="text-xs text-muted-foreground">Daily Users</p>
                    </div>
                    <div class="p-3 bg-muted/20 rounded-lg">
                      <p class="text-lg font-bold">{{ engagementData.platformUsage.sessionDuration }}</p>
                      <p class="text-xs text-muted-foreground">Avg. Session</p>
                    </div>
                    <div class="p-3 bg-muted/20 rounded-lg">
                      <p class="text-lg font-bold">{{ engagementData.platformUsage.pageViews }}</p>
                      <p class="text-xs text-muted-foreground">Page Views</p>
                    </div>
                  </div>

                  <div class="space-y-3">
                    <h4 class="text-sm font-medium">Feature Usage</h4>
                    <div class="space-y-2">
                      <div class="flex justify-between text-sm">
                        <span>QR Payments</span>
                        <span>{{ engagementData.platformUsage.featureUsage.qrPayments }}%</span>
                      </div>
                      <div class="w-full bg-muted rounded-full h-1.5">
                        <div class="bg-blue-500 h-1.5 rounded-full" :style="{ width: engagementData.platformUsage.featureUsage.qrPayments + '%' }"></div>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </TabsContent>

        <!-- Financial Analytics Tab -->
        <TabsContent value="financial" class="space-y-6">
          <div class="grid gap-6">
            <!-- Revenue Stream Breakdown -->
            <Card>
              <CardHeader>
                <CardTitle class="flex items-center gap-2">
                  <PieChart class="h-5 w-5" />
                  Revenue Stream Breakdown
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div class="grid gap-4 md:grid-cols-4">
                  <div v-for="stream in financialData.revenueStreams" :key="stream.name" 
                       class="p-4 border border-border rounded-lg">
                    <h4 class="font-medium text-sm mb-2">{{ stream.name }}</h4>
                    <p class="text-xl font-bold mb-1">₱{{ stream.amount.toLocaleString() }}</p>
                    <div class="flex items-center gap-2">
                      <div class="w-full bg-muted rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full" :style="{ width: stream.percentage + '%' }"></div>
                      </div>
                      <span class="text-xs text-muted-foreground whitespace-nowrap">{{ stream.percentage }}%</span>
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>

            <!-- Payment Method & Collection Efficiency -->
            <div class="grid gap-6 lg:grid-cols-2">
              <!-- Payment Method Distribution -->
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center gap-2">
                    <CreditCard class="h-5 w-5" />
                    Payment Method Distribution
                  </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                  <div v-for="method in financialData.paymentMethods" :key="method.method" 
                       class="space-y-2">
                    <div class="flex justify-between items-center">
                      <span class="text-sm font-medium">{{ method.method }}</span>
                      <div class="flex items-center gap-2">
                        <span class="text-sm">{{ method.transactions }}</span>
                        <Badge variant="outline">{{ method.percentage }}%</Badge>
                      </div>
                    </div>
                    <div class="w-full bg-muted rounded-full h-2">
                      <div class="bg-blue-500 h-2 rounded-full" :style="{ width: method.percentage + '%' }"></div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <!-- Collection Efficiency Metrics -->
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center gap-2">
                    <TrendingUp class="h-5 w-5" />
                    Collection Efficiency Metrics
                  </CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                  <div class="text-center p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-2xl font-bold text-green-600">{{ financialData.collectionEfficiency.efficiencyRate }}%</p>
                    <p class="text-sm text-green-700">Collection Rate</p>
                  </div>

                  <div class="grid grid-cols-3 gap-2 text-center text-sm">
                    <div class="p-2 bg-blue-50 rounded border border-blue-100">
                      <p class="font-bold text-blue-600">₱{{ financialData.collectionEfficiency.collected.toLocaleString() }}</p>
                      <p class="text-xs text-blue-700">Collected</p>
                    </div>
                    <div class="p-2 bg-yellow-50 rounded border border-yellow-100">
                      <p class="font-bold text-yellow-600">₱{{ financialData.collectionEfficiency.pending.toLocaleString() }}</p>
                      <p class="text-xs text-yellow-700">Pending</p>
                    </div>
                    <div class="p-2 bg-red-50 rounded border border-red-100">
                      <p class="font-bold text-red-600">₱{{ financialData.collectionEfficiency.overdue.toLocaleString() }}</p>
                      <p class="text-xs text-red-700">Overdue</p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </TabsContent>

        <!-- Custom Reports Tab -->
        <TabsContent value="custom" class="space-y-6">
          <div class="grid gap-6 lg:grid-cols-3">
            <!-- Report Builder Interface -->
            <Card class="lg:col-span-2">
              <CardHeader>
                <CardTitle class="flex items-center gap-2">
                  <Settings class="h-5 w-5" />
                  Report Builder Interface
                </CardTitle>
              </CardHeader>
              <CardContent class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                  <div class="space-y-2">
                    <Label for="reportName">Report Name</Label>
                    <Input id="reportName" v-model="reportBuilder.reportName" placeholder="Enter report name" />
                  </div>
                  
                  <div class="space-y-2">
                    <Label for="dateRange">Date Range</Label>
                    <Select v-model="reportBuilder.dateRange">
                      <SelectTrigger>
                        <SelectValue placeholder="Select date range" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="last7days">Last 7 days</SelectItem>
                        <SelectItem value="last30days">Last 30 days</SelectItem>
                        <SelectItem value="last90days">Last 90 days</SelectItem>
                        <SelectItem value="custom">Custom range</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div class="space-y-2">
                    <Label for="dataSource">Data Source</Label>
                    <Select v-model="reportBuilder.dataSource">
                      <SelectTrigger>
                        <SelectValue placeholder="Select data source" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="members">Members</SelectItem>
                        <SelectItem value="payments">Payments</SelectItem>
                        <SelectItem value="events">Events</SelectItem>
                        <SelectItem value="transactions">Transactions</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div class="space-y-2">
                    <Label for="visualization">Visualization Type</Label>
                    <Select v-model="reportBuilder.visualization">
                      <SelectTrigger>
                        <SelectValue placeholder="Select chart type" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="bar">Bar Chart</SelectItem>
                        <SelectItem value="line">Line Chart</SelectItem>
                        <SelectItem value="pie">Pie Chart</SelectItem>
                        <SelectItem value="table">Data Table</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>

                <div class="flex gap-2 pt-4">
                  <Button @click="generateReport" class="flex-1">
                    <Eye class="h-4 w-4 mr-2" />
                    Preview Report
                  </Button>
                  <Button variant="outline" @click="generateReport">
                    <Download class="h-4 w-4 mr-2" />
                    Generate
                  </Button>
                </div>
              </CardContent>
            </Card>

            <!-- Scheduled Reports -->
            <Card>
              <CardHeader>
                <CardTitle class="flex items-center gap-2">
                  <Clock class="h-5 w-5" />
                  Scheduled Reports
                </CardTitle>
              </CardHeader>
              <CardContent class="space-y-4">
                <div class="space-y-2">
                  <Label for="schedule">Schedule Frequency</Label>
                  <Select v-model="reportBuilder.schedule">
                    <SelectTrigger>
                      <SelectValue placeholder="Select frequency" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="none">No Schedule</SelectItem>
                      <SelectItem value="daily">Daily</SelectItem>
                      <SelectItem value="weekly">Weekly</SelectItem>
                      <SelectItem value="monthly">Monthly</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div class="space-y-2">
                  <Label for="recipients">Email Recipients</Label>
                  <Input id="recipients" v-model="reportBuilder.recipients" 
                         placeholder="email1@example.com, email2@example.com" />
                </div>

                <Button @click="scheduleReport" variant="outline" class="w-full">
                  <Mail class="h-4 w-4 mr-2" />
                  Schedule Report
                </Button>

                <div class="pt-4 border-t">
                  <h4 class="text-sm font-medium mb-2">Active Schedules</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between items-center p-2 bg-muted/20 rounded">
                      <div>
                        <p class="text-sm font-medium">Monthly Financial Summary</p>
                        <p class="text-xs text-muted-foreground">Every 1st of month</p>
                      </div>
                      <Badge variant="outline">Active</Badge>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-muted/20 rounded">
                      <div>
                        <p class="text-sm font-medium">Weekly Engagement Report</p>
                        <p class="text-xs text-muted-foreground">Every Monday</p>
                      </div>
                      <Badge variant="outline">Active</Badge>
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>

          <!-- Data Visualization Options -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <BarChart3 class="h-5 w-5" />
                Data Visualization Options
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="grid gap-4 md:grid-cols-4">
                <div class="p-4 border border-dashed border-muted-foreground/25 rounded-lg text-center hover:bg-muted/20 cursor-pointer">
                  <BarChart3 class="h-8 w-8 mx-auto mb-2 text-muted-foreground" />
                  <p class="text-sm font-medium">Bar Chart</p>
                  <p class="text-xs text-muted-foreground">Compare categories</p>
                </div>
                <div class="p-4 border border-dashed border-muted-foreground/25 rounded-lg text-center hover:bg-muted/20 cursor-pointer">
                  <PieChart class="h-8 w-8 mx-auto mb-2 text-muted-foreground" />
                  <p class="text-sm font-medium">Pie Chart</p>
                  <p class="text-xs text-muted-foreground">Show proportions</p>
                </div>
                <div class="p-4 border border-dashed border-muted-foreground/25 rounded-lg text-center hover:bg-muted/20 cursor-pointer">
                  <TrendingUp class="h-8 w-8 mx-auto mb-2 text-muted-foreground" />
                  <p class="text-sm font-medium">Line Chart</p>
                  <p class="text-xs text-muted-foreground">Track trends</p>
                </div>
                <div class="p-4 border border-dashed border-muted-foreground/25 rounded-lg text-center hover:bg-muted/20 cursor-pointer">
                  <FileText class="h-8 w-8 mx-auto mb-2 text-muted-foreground" />
                  <p class="text-sm font-medium">Data Table</p>
                  <p class="text-xs text-muted-foreground">Detailed view</p>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  </AppLayout>
</template>
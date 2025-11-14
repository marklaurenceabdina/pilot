<script setup lang="ts">
import { ref, computed } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import EditUserModal from './EditUserModal.vue'
import DeleteUserModal from './DeleteUserModal.vue'
import {
  Search,
  ChevronDown,
  Pencil,
  Trash2,
  User,
  Calendar,
  Filter,
  ArrowUpDown
} from "lucide-vue-next"

interface User {
    id: number
    name: string
    email: string
    student_id: string
    program: string
    year: string
    role: 'Member' | 'Officer' | 'Admin'
    status: 'active' | 'inactive' | 'pending'  // CHANGED: Added pending status
    last_login: string
}

const props = defineProps<{
    users: User[]
}>()

// State
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedUser = ref<User | null>(null)
const searchQuery = ref("")
const roleFilter = ref("all")
const statusFilter = ref("all")  // CHANGED: Now includes 'pending'
const sortField = ref("id")
const sortDirection = ref("desc")
const isFilterOpen = ref(false)  // CHANGED: Added for dropdown state

// Computed
const filteredAndSortedUsers = computed(() => {
    let filtered = props.users.filter(user => {
        const matchesSearch = user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            user.student_id.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            user.program.toLowerCase().includes(searchQuery.value.toLowerCase())
        
        const matchesRole = roleFilter.value === 'all' || user.role === roleFilter.value
        const matchesStatus = statusFilter.value === 'all' || user.status === statusFilter.value
        
        return matchesSearch && matchesRole && matchesStatus
    })

    // Sort
    return filtered.sort((a, b) => {
        const aValue = a[sortField.value as keyof User]
        const bValue = b[sortField.value as keyof User]
        
        if (sortDirection.value === 'asc') {
            return aValue > bValue ? 1 : -1
        } else {
            return aValue < bValue ? 1 : -1
        }
    })
})

// CHANGED: Updated to use shadcn/ui Badge variants
const getRoleVariant = (role: string) => {
    switch (role) {
        case 'Admin': return 'destructive'
        case 'Officer': return 'default'
        case 'Member': return 'secondary'
        default: return 'outline'
    }
}

// CHANGED: Updated to use shadcn/ui Badge variants and added pending status
const getStatusVariant = (status: string) => {
    switch (status) {
        case 'active': return 'default'
        case 'inactive': return 'destructive'
        case 'pending': return 'outline'
        default: return 'secondary'
    }
}

// CHANGED: Updated sort icon function to use Lucide icons
const getSortIcon = (field: string) => {
    if (sortField.value !== field) {
        return ArrowUpDown
    }
    return sortDirection.value === 'asc' ? ChevronDown : ChevronDown
}

// Methods
const openEditModal = (user: User) => {
    selectedUser.value = user
    showEditModal.value = true
}

const openDeleteModal = (user: User) => {
    selectedUser.value = user
    showDeleteModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    selectedUser.value = null
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    selectedUser.value = null
}

const sortBy = (field: string) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }
}

// CHANGED: Added function to clear all filters
const clearFilters = () => {
    searchQuery.value = ""
    roleFilter.value = "all"
    statusFilter.value = "all"
}
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-foreground">User Management</h1>
                <p class="text-muted-foreground">Manage and track all system users</p>
            </div>
        </div>

        <!-- Search + Filter -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search -->
            <div class="relative flex-1 min-w-[300px]">
                <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                <Input
                    v-model="searchQuery"
                    placeholder="Search users..."
                    class="pl-9"
                />
            </div>

            <!-- Role Filter Dropdown -->
            <DropdownMenu v-model:open="isFilterOpen">
                <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="gap-2">
                        <Filter class="h-4 w-4" />
                        {{ roleFilter === 'all' ? 'All Roles' : roleFilter }}
                        <ChevronDown 
                            class="h-4 w-4 transition-transform"
                            :class="{ 'rotate-180': isFilterOpen }"
                        />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem 
                        @click="roleFilter = 'all'"
                        :class="{ 'bg-accent': roleFilter === 'all' }"
                    >
                        All Roles
                    </DropdownMenuItem>
                    <DropdownMenuItem 
                        @click="roleFilter = 'Admin'"
                        :class="{ 'bg-accent': roleFilter === 'Admin' }"
                    >
                        Admin
                    </DropdownMenuItem>
                    <DropdownMenuItem 
                        @click="roleFilter = 'Officer'"
                        :class="{ 'bg-accent': roleFilter === 'Officer' }"
                    >
                        Officer
                    </DropdownMenuItem>
                    <DropdownMenuItem 
                        @click="roleFilter = 'Member'"
                        :class="{ 'bg-accent': roleFilter === 'Member' }"
                    >
                        Member
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <!-- Status Filter Dropdown -->
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="gap-2">
                        <Filter class="h-4 w-4" />
                        {{ statusFilter === 'all' ? 'All Status' : statusFilter }}
                        <ChevronDown class="h-4 w-4" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem 
                        @click="statusFilter = 'all'"
                        :class="{ 'bg-accent': statusFilter === 'all' }"
                    >
                        All Status
                    </DropdownMenuItem>
                    <DropdownMenuItem 
                        @click="statusFilter = 'active'"
                        :class="{ 'bg-accent': statusFilter === 'active' }"
                    >
                        Active
                    </DropdownMenuItem>
                    <DropdownMenuItem 
                        @click="statusFilter = 'inactive'"
                        :class="{ 'bg-accent': statusFilter === 'inactive' }"
                    >
                        Inactive
                    </DropdownMenuItem>
                    <!-- CHANGED: Added pending filter option -->
                    <DropdownMenuItem 
                        @click="statusFilter = 'pending'"
                        :class="{ 'bg-accent': statusFilter === 'pending' }"
                    >
                        Pending
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <!-- Clear Filters -->
            <Button
                v-if="roleFilter !== 'all' || statusFilter !== 'all' || searchQuery"
                @click="clearFilters"
                variant="destructive"
                size="sm"
            >
                Clear Filters
            </Button>
        </div>

        <!-- Users Table Card -->
        <Card>
            <CardHeader>
                <CardTitle>All Users</CardTitle>
                <CardDescription>
                    {{ filteredAndSortedUsers.length }} users found
                </CardDescription>
            </CardHeader>
            <CardContent class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('name')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Name
                                        <component :is="getSortIcon('name')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('email')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Email
                                        <component :is="getSortIcon('email')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-muted-foreground">Student ID</th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('program')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Program
                                        <component :is="getSortIcon('program')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('year')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Year
                                        <component :is="getSortIcon('year')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('role')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Role
                                        <component :is="getSortIcon('role')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('status')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Status
                                        <component :is="getSortIcon('status')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3">
                                    <Button 
                                        @click="sortBy('last_login')"
                                        variant="ghost"
                                        class="flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground p-0 h-auto"
                                    >
                                        Last Login
                                        <component :is="getSortIcon('last_login')" class="h-4 w-4" />
                                    </Button>
                                </th>
                                <th class="text-left px-6 py-3 text-sm font-medium text-muted-foreground">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr 
                                v-for="user in filteredAndSortedUsers" 
                                :key="user.id" 
                                class="hover:bg-muted/50 transition-colors"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                            <User class="h-4 w-4 text-primary" />
                                        </div>
                                        <div class="font-medium text-foreground">{{ user.name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-muted-foreground">
                                    {{ user.email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-muted-foreground">
                                    {{ user.student_id || '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-muted-foreground">
                                    {{ user.program || '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-muted-foreground">
                                    {{ user.year || '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Badge :variant="getRoleVariant(user.role)">
                                        {{ user.role }}
                                    </Badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Badge :variant="getStatusVariant(user.status)">
                                        {{ user.status }}
                                    </Badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-muted-foreground">
                                        <Calendar class="h-3 w-3" />
                                        {{ user.last_login }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <Button 
                                            @click="openEditModal(user)"
                                            variant="ghost"
                                            size="icon"
                                            class="h-8 w-8"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Button>
                                        <Button 
                                            @click="openDeleteModal(user)"
                                            variant="ghost"
                                            size="icon"
                                            class="h-8 w-8 text-red-500 hover:text-red-600"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Empty State -->
                            <tr v-if="filteredAndSortedUsers.length === 0">
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="mx-auto mb-4 h-12 w-12 rounded-full bg-muted flex items-center justify-center">
                                            <User class="h-6 w-6 text-muted-foreground" />
                                        </div>
                                        <h3 class="text-lg font-medium mb-2">No users found</h3>
                                        <p class="text-muted-foreground mb-4">
                                            {{ searchQuery || roleFilter !== 'all' || statusFilter !== 'all'
                                                ? 'Try adjusting your filters or search terms.' 
                                                : 'No users available in the system.'
                                            }}
                                        </p>
                                        <Button 
                                            v-if="!searchQuery && roleFilter === 'all' && statusFilter === 'all'"
                                            variant="outline"
                                            class="gap-2"
                                        >
                                            <User class="h-4 w-4" />
                                            Add First User
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </CardContent>
        </Card>
    </div>

    <!-- Modals -->
    <EditUserModal 
        v-if="showEditModal && selectedUser" 
        :user="selectedUser"
        @close="closeEditModal"
    />
    
    <DeleteUserModal 
        v-if="showDeleteModal && selectedUser" 
        :user="selectedUser"
        @close="closeDeleteModal"
    />
</template>
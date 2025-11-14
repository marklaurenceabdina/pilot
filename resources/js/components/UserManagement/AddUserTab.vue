<script setup lang="ts">
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Alert, AlertDescription } from '@/components/ui/alert'
import {
  User,
  Mail,
  BookOpen,
  Settings,
  AlertTriangle,
  Plus,
  RotateCcw,
  Loader2
} from "lucide-vue-next"

const emit = defineEmits<{
    userCreated: []
}>()

// Form state
const form = reactive({
    name: '',
    email: '',
    studentId: '',
    program: '',
    year: '',
    role: 'Member' as 'Member' | 'Officer' | 'Admin',
    status: 'active' as 'active' | 'inactive' | 'pending',  // CHANGED: Added pending status
    lastLogin: ''
})

const isSubmitting = ref(false)
const errors = ref<Record<string, string>>({})

// Form validation
const validateForm = () => {
    errors.value = {}
    
    if (!form.name.trim()) {
        errors.value.name = 'Name is required'
    }
    
    if (!form.email.trim()) {
        errors.value.email = 'Email is required'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        errors.value.email = 'Please enter a valid email address'
    }
    
    if (!form.program.trim()) {
        errors.value.program = 'Program is required'
    }
    
    if (!form.year.trim()) {
        errors.value.year = 'Year is required'
    }
    
    return Object.keys(errors.value).length === 0
}

// Submit form
const submitForm = () => {
    if (!validateForm()) return
    
    isSubmitting.value = true
    
    router.post('/users', form, {
        onSuccess: () => {
            resetForm()
            emit('userCreated')
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
        name: '',
        email: '',
        studentId: '',
        program: '',
        year: '',
        role: 'Member',
        status: 'active',
        lastLogin: ''
    })
    errors.value = {}
}

// Programs list (you can customize this based on your needs)
const programs = [
    'Computer Science',
    'Information System',
    'Library Information System'
]

// Year levels
const years = [
    '1st Year',
    '2nd Year', 
    '3rd Year',
    '4th Year',
    '5th Year'
]
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-foreground">Add New User</h1>
                <p class="text-muted-foreground">Create a new user account for the system</p>
            </div>
        </div>

        <!-- Form Card -->
        <Card class="max-w-2xl mx-auto w-full">
            <CardHeader>
                <CardTitle>User Information</CardTitle>
                <CardDescription>Enter the details for the new user account</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Personal Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <User class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Personal Information</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="space-y-2">
                                <Label for="name">
                                    Full Name <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Enter full name"
                                    :class="errors.name ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.name" class="text-sm text-destructive">{{ errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <Label for="email">
                                    Email Address <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="Enter email address"
                                    :class="errors.email ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <BookOpen class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">Academic Information</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-4">
                            <!-- Student ID -->
                            <div class="space-y-2">
                                <Label for="studentId">Student ID</Label>
                                <Input
                                    id="studentId"
                                    v-model="form.studentId"
                                    type="text"
                                    placeholder="Enter student ID"
                                    :class="errors.studentId ? 'border-destructive' : ''"
                                />
                                <p v-if="errors.studentId" class="text-sm text-destructive">{{ errors.studentId }}</p>
                            </div>

                            <!-- Program -->
                            <div class="space-y-2">
                                <Label for="program">
                                    Program <span class="text-destructive">*</span>
                                </Label>
                                <Select v-model="form.program">
                                    <SelectTrigger :class="errors.program ? 'border-destructive' : ''">
                                        <SelectValue placeholder="Select Program" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem 
                                            v-for="program in programs" 
                                            :key="program" 
                                            :value="program"
                                        >
                                            {{ program }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <p v-if="errors.program" class="text-sm text-destructive">{{ errors.program }}</p>
                            </div>

                            <!-- Year -->
                            <div class="space-y-2">
                                <Label for="year">
                                    Year Level <span class="text-destructive">*</span>
                                </Label>
                                <Select v-model="form.year">
                                    <SelectTrigger :class="errors.year ? 'border-destructive' : ''">
                                        <SelectValue placeholder="Select Year" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem 
                                            v-for="year in years" 
                                            :key="year" 
                                            :value="year"
                                        >
                                            {{ year }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <p v-if="errors.year" class="text-sm text-destructive">{{ errors.year }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- System Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <Settings class="h-5 w-5 text-primary" />
                            <h3 class="text-lg font-medium text-foreground">System Information</h3>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Role -->
                            <div class="space-y-2">
                                <Label for="role">
                                    Role <span class="text-destructive">*</span>
                                </Label>
                                <Select v-model="form.role">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select Role" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="Member">Member</SelectItem>
                                        <SelectItem value="Officer">Officer</SelectItem>
                                        <SelectItem value="Admin">Admin</SelectItem>
                                    </SelectContent>
                                </Select>
                                <p class="text-sm text-muted-foreground">
                                    Default role is Member. Admins have full access.
                                </p>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <Label for="status">
                                    Status <span class="text-destructive">*</span>
                                </Label>
                                <Select v-model="form.status">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="active">Active</SelectItem>
                                        <SelectItem value="inactive">Inactive</SelectItem>
                                        <!-- CHANGED: Added pending status option -->
                                        <SelectItem value="pending">Pending</SelectItem>
                                    </SelectContent>
                                </Select>
                                <p class="text-sm text-muted-foreground">
                                    Active users can login to the system.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Default Password Notice -->
                    <Alert class="bg-warning/20 border-warning">
                        <AlertTriangle class="h-4 w-4 text-warning-foreground" />
                        <AlertDescription class="text-warning-foreground">
                            <strong>Default Password:</strong> New users will be created with the default password 
                            <strong>"password123"</strong>. They should change this upon first login.
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
                            {{ isSubmitting ? 'Creating User...' : 'Create User' }}
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
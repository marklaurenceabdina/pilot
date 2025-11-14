<!-- components/UserForm.vue -->
<template>
  <form @submit.prevent="$emit('submit')" class="space-y-4">
    <!-- Name -->
    <div class="grid grid-cols-3 gap-4">
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">First Name</label>
        <Input v-model="form.firstName" type="text" :required="required" />
        <div v-if="form.errors.firstName" class="text-sm text-destructive">{{ form.errors.firstName }}</div>
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Middle Name</label>
        <Input v-model="form.middleName" type="text" />
        <div v-if="form.errors.middleName" class="text-sm text-destructive">{{ form.errors.middleName }}</div>
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Last Name</label>
        <Input v-model="form.lastName" type="text" :required="required" />
        <div v-if="form.errors.lastName" class="text-sm text-destructive">{{ form.errors.lastName }}</div>
      </div>
    </div>

    <!-- Email -->
    <div class="space-y-2">
      <label class="text-sm font-medium text-foreground">Email</label>
      <Input v-model="form.email" type="email" required />
      <div v-if="form.errors.email" class="text-sm text-destructive">{{ form.errors.email }}</div>
    </div>

    <!-- Student ID -->
    <div class="space-y-2">
      <label class="text-sm font-medium text-foreground">Student ID</label>
      <Input v-model="form.studentId" type="text" />
      <div v-if="form.errors.studentId" class="text-sm text-destructive">{{ form.errors.studentId }}</div>
    </div>

    <!-- Program + Year -->
    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Program</label>
        <Select v-model="form.program">
          <SelectTrigger>
            <SelectValue placeholder="Select program" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="Library and Information Science">Library and Information Science</SelectItem>
            <SelectItem value="Computer Science">Computer Science</SelectItem>
            <SelectItem value="Information System">Information System</SelectItem>
          </SelectContent>
        </Select>
        <div v-if="form.errors.program" class="text-sm text-destructive">{{ form.errors.program }}</div>
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Year Level</label>
        <Select v-model="form.year">
          <SelectTrigger>
            <SelectValue placeholder="Select year" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="1st Year">1st Year</SelectItem>
            <SelectItem value="2nd Year">2nd Year</SelectItem>
            <SelectItem value="3rd Year">3rd Year</SelectItem>
            <SelectItem value="4th Year">4th Year</SelectItem>
            <SelectItem value="5th Year">5th Year</SelectItem>
          </SelectContent>
        </Select>
        <div v-if="form.errors.year" class="text-sm text-destructive">{{ form.errors.year }}</div>
      </div>
    </div>

    <!-- Role + Status -->
    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Role</label>
        <Select v-model="form.role">
          <SelectTrigger>
            <SelectValue placeholder="Select role" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="Member">Member</SelectItem>
            <SelectItem value="Officer">Officer</SelectItem>
            <SelectItem value="Admin">Admin</SelectItem>
          </SelectContent>
        </Select>
        <div v-if="form.errors.role" class="text-sm text-destructive">{{ form.errors.role }}</div>
      </div>
      <div class="space-y-2">
        <label class="text-sm font-medium text-foreground">Status</label>
        <Select v-model="form.status">
          <SelectTrigger>
            <SelectValue placeholder="Select status" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="active">Active</SelectItem>
            <SelectItem value="inactive">Inactive</SelectItem>
          </SelectContent>
        </Select>
        <div v-if="form.errors.status" class="text-sm text-destructive">{{ form.errors.status }}</div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-2 pt-4">
      <Button type="button" variant="outline" @click="$emit('cancel')">
        Cancel
      </Button>
      <Button type="submit" :disabled="form.processing">
        {{ submitText }}
      </Button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { Input } from '@/components/ui/input'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Button } from '@/components/ui/button'

interface Props {
  form: any
  submitText?: string
  required?: boolean
}

withDefaults(defineProps<Props>(), {
  submitText: 'Save',
  required: true
})

defineEmits<{
  submit: []
  cancel: []
}>()
</script>
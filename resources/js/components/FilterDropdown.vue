<!-- components/FilterDropdown.vue -->
<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="outline" class="gap-2">
        <span>Filter</span>
        <ChevronDown class="h-4 w-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end" class="w-64">
      <div class="space-y-3 p-2">
        <Select v-model="programModel">
          <SelectTrigger>
            <SelectValue placeholder="All Programs" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="">All Programs</SelectItem>
            <SelectItem value="Library and Information Science">Library and Information Science</SelectItem>
            <SelectItem value="Computer Science">Computer Science</SelectItem>
            <SelectItem value="Information System">Information System</SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="yearModel">
          <SelectTrigger>
            <SelectValue placeholder="All Years" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="">All Years</SelectItem>
            <SelectItem value="1st Year">1st Year</SelectItem>
            <SelectItem value="2nd Year">2nd Year</SelectItem>
            <SelectItem value="3rd Year">3rd Year</SelectItem>
            <SelectItem value="4th Year">4th Year</SelectItem>
            <SelectItem value="5th Year">5th Year</SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="roleModel">
          <SelectTrigger>
            <SelectValue placeholder="All Roles" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="">All Roles</SelectItem>
            <SelectItem value="Member">Member</SelectItem>
            <SelectItem value="Officer">Officer</SelectItem>
            <SelectItem value="Admin">Admin</SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="statusModel">
          <SelectTrigger>
            <SelectValue placeholder="All Status" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="">All Status</SelectItem>
            <SelectItem value="active">Active</SelectItem>
            <SelectItem value="inactive">Inactive</SelectItem>
          </SelectContent>
        </Select>

        <Button 
          @click="$emit('clear')"
          variant="outline" 
          class="w-full"
        >
          Clear Filters
        </Button>
      </div>
    </DropdownMenuContent>
  </DropdownMenu>
</template>

<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import {computed} from 'vue'

interface Props {
  program: string
  year: string
  role: string
  status: string
}

const props = defineProps<Props>()

const emit = defineEmits<{
  'update:program': [string]
  'update:year': [string]
  'update:role': [string]
  'update:status': [string]
  clear: []
}>()

const programModel = computed({
  get: () => props.program,
  set: (value: string) => emit('update:program', value)
})

const yearModel = computed({
  get: () => props.year,
  set: (value: string) => emit('update:year', value)
})

const roleModel = computed({
  get: () => props.role,
  set: (value: string) => emit('update:role', value)
})

const statusModel = computed({
  get: () => props.status,
  set: (value: string) => emit('update:status', value)
})
</script>
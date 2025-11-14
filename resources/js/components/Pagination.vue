<!-- components/Pagination.vue -->
<template>
  <div class="flex items-center justify-between text-sm text-muted-foreground">
    <!-- Left: Info text -->
    <p>
      Showing 
      {{ (currentPage - 1) * perPage + 1 }} 
      – 
      {{ Math.min(currentPage * perPage, totalItems) }} 
      of {{ totalItems }} items 
      (page {{ currentPage }} of {{ totalPages }})
    </p>

    <!-- Right: Rows per page + Pagination -->
    <div class="flex items-center gap-6">
      <!-- Rows per page -->
      <div class="flex items-center gap-2">
        <span class="text-sm">Rows per page:</span>
        <Select v-model="perPageModel">
          <SelectTrigger class="w-20">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="5">5</SelectItem>
            <SelectItem value="10">10</SelectItem>
            <SelectItem value="20">20</SelectItem>
            <SelectItem value="50">50</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <!-- Pagination buttons -->
      <div class="flex gap-1">
        <Button
          variant="outline"
          size="sm"
          @click="$emit('update:currentPage', Math.max(1, currentPage - 1))"
          :disabled="currentPage === 1"
        >
          Previous
        </Button>
        
        <Button
          v-for="pageNum in totalPages"
          v-show="shouldShowPage(pageNum)"
          :key="pageNum"
          variant="outline"
          size="sm"
          @click="$emit('update:currentPage', pageNum)"
          :class="currentPage === pageNum ? 'bg-primary text-primary-foreground' : ''"
        >
          {{ pageNum }}
        </Button>

        <span 
          v-if="totalPages > 5 && currentPage < totalPages - 2" 
          class="flex items-center px-3 text-muted-foreground"
        >
          ...
        </span>

        <Button
          variant="outline"
          size="sm"
          @click="$emit('update:currentPage', Math.min(totalPages, currentPage + 1))"
          :disabled="currentPage === totalPages"
        >
          Next
        </Button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Button } from '@/components/ui/button'
import {computed} from 'vue'

interface Props {
  currentPage: number
  perPage: number
  totalItems: number
  totalPages: number
}

const props = defineProps<Props>()

const emit = defineEmits<{
  'update:currentPage': [number]
  'update:perPage': [number]
}>()

const perPageModel = computed({
  get: () => props.perPage.toString(),
  set: (value: string) => emit('update:perPage', parseInt(value))
})

function shouldShowPage(pageNum: number): boolean {
  return Math.abs(pageNum - props.currentPage) <= 2 || pageNum === 1 || pageNum === props.totalPages
}
</script>
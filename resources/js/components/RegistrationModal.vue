<!-- components/RegistrationModal.vue -->
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { X } from 'lucide-vue-next';
import { onMounted, onUnmounted } from 'vue';

interface Props {
  open: boolean;
  title?: string;
  description?: string;
  showCloseButton?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  title: '',
  description: '',
  showCloseButton: true
});

const emit = defineEmits<{
  close: []
}>();

const handleEscape = (e: KeyboardEvent) => {
  if (e.key === 'Escape' && props.open) {
    emit('close');
  }
};

const handleBackdropClick = (e: MouseEvent) => {
  if (e.target === e.currentTarget) {
    emit('close');
  }
};

onMounted(() => {
  document.addEventListener('keydown', handleEscape);
  if (props.open) {
    document.body.style.overflow = 'hidden';
  }
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
  document.body.style.overflow = '';
});
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="open"
        class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm"
        @click="handleBackdropClick"
      >
        <div class="fixed left-[50%] top-[50%] translate-x-[-50%] translate-y-[-50%]">
          <Transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div
              v-if="open"
              class="grid w-full max-w-lg gap-4 border bg-background p-6 shadow-lg sm:rounded-lg"
            >
              <!-- Header -->
              <div class="flex flex-col space-y-1.5 text-center sm:text-left">
                <div class="flex items-center justify-between">
                  <h2 v-if="title" class="text-lg font-semibold leading-none tracking-tight">
                    {{ title }}
                  </h2>
                  <Button
                    v-if="showCloseButton"
                    variant="ghost"
                    size="sm"
                    class="h-6 w-6 p-0"
                    @click="emit('close')"
                  >
                    <X class="h-4 w-4" />
                    <span class="sr-only">Close</span>
                  </Button>
                </div>
                <p v-if="description" class="text-sm text-muted-foreground">
                  {{ description }}
                </p>
              </div>

              <!-- Content -->
              <div class="grid gap-4">
                <slot />
              </div>

              <!-- Footer -->
              <div v-if="$slots.footer" class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <slot name="footer" />
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
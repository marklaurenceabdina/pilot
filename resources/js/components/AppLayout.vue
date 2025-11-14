<!-- SIDEBAR AND NAV-->

<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';

defineProps<{
  breadcrumbs?: Array<{ title: string; href: string }>
}>()
</script>

<template>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <AppSidebar />

        <!-- Main content -->
        <div class="flex flex-1 flex-col">
            <!-- Header -->
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />

            <!-- Page content -->
            <main class="flex-1 overflow-auto">
                <slot />
            </main>
        </div>
    </div>
</template>

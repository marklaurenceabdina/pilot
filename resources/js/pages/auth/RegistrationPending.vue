<!-- RegistrationPending.vue -->
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { CheckCircle, Clock } from 'lucide-vue-next';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';

// Define proper TypeScript interfaces
interface FlashProps {
  registration_pending?: boolean;
  email?: string;
  success?: string;
  error?: string;
}

interface CustomPageProps extends InertiaPageProps {
  flash?: FlashProps;
}

// Use the typed page
const page = usePage<CustomPageProps>();

// Debug logging
console.log('Flash props:', page.props.flash);
console.log('Email:', page.props.flash?.email);

const handleGoToLogin = () => {
  router.visit(route('login'));
};
</script>

<template>
    <AuthBase 
        title="Registration Submitted" 
        description="Your account is pending approval"
        :show-header="false"
    >
        <Head title="Registration Pending" />

        <div class="flex flex-col items-center text-center space-y-6 py-8">
            <!-- Success Icon -->
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                <CheckCircle class="h-8 w-8 text-green-600 dark:text-green-400" />
            </div>
            
            <!-- Success Message -->
            <div class="space-y-4">
                <h1 class="text-2xl font-bold text-foreground">
                    Registration Submitted Successfully
                </h1>
                
                <div class="flex items-center justify-center space-x-2 text-lg text-muted-foreground">
                    <Clock class="h-5 w-5" />
                    <span class="font-medium">Account Pending Approval</span>
                </div>
                
                <div class="space-y-3 text-sm text-muted-foreground max-w-md">
                    <p>
                        Thank you for registering! Your account request has been received and is currently pending administrator approval.
                    </p>
                    
                    <div v-if="page.props.flash?.email" class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-md">
                        <p class="text-blue-800 dark:text-blue-300 font-medium">
                            Registration submitted for: <span class="font-bold">{{ page.props.flash.email }}</span>
                        </p>
                    </div>
                    
                    <div v-else class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-md">
                        <p class="text-blue-800 dark:text-blue-300 font-medium">
                            Your registration has been submitted successfully.
                        </p>
                    </div>
                    
                    <p class="pt-2">
                        You will receive an email notification once your account has been activated. 
                        This process typically takes 24-48 hours.
                    </p>
                    
                    <p>
                        If you have any questions, please contact the system administrator.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3 w-full max-w-xs pt-4">
                <Button 
                    @click="handleGoToLogin"
                    class="w-full"
                    size="lg"
                >
                    Return to Login
                </Button>
                
                <Button 
                    variant="outline"
                    @click="router.visit(route('register'))"
                    class="w-full"
                >
                    Register Another Account
                </Button>
            </div>
        </div>
    </AuthBase>
</template>
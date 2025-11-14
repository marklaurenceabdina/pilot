<!-- Register.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Form, Head, usePage, router } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';

// 1. Define just the extra props you need
interface FlashProps {
  registration_pending?: boolean;
}

// 2. Extend Inertia's PageProps
interface CustomPageProps extends InertiaPageProps {
  flash?: FlashProps;
}

// 3. Use it with `usePage`
const page = usePage<CustomPageProps>();

const isRegistrationSuccess = computed(() => {
  return page.props.flash?.registration_pending === true;
});

// Redirect to pending page if registration was successful
if (isRegistrationSuccess.value) {
  router.visit(route('registration.pending'));
}
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <Form
            method="post"
            :action="route('register')"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <!-- Name Fields -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="grid gap-2">
                        <Label for="firstName" class="text-sm font-medium text-foreground">First Name</Label>
                        <Input 
                            id="firstName" 
                            type="text" 
                            required 
                            autofocus 
                            :tabindex="1" 
                            autocomplete="given-name" 
                            name="firstName" 
                            placeholder="First name" 
                        />
                        <InputError :message="errors.firstName" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="middleName" class="text-sm font-medium text-foreground">Middle Name</Label>
                        <Input 
                            id="middleName" 
                            type="text" 
                            :tabindex="2" 
                            autocomplete="additional-name" 
                            name="middleName" 
                            placeholder="Middle name" 
                        />
                        <InputError :message="errors.middleName" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="lastName" class="text-sm font-medium text-foreground">Last Name</Label>
                        <Input 
                            id="lastName" 
                            type="text" 
                            required 
                            :tabindex="3" 
                            autocomplete="family-name" 
                            name="lastName" 
                            placeholder="Last name" 
                        />
                        <InputError :message="errors.lastName" />
                    </div>
                </div>

                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-medium text-foreground">Email</Label>
                    <Input 
                        id="email" 
                        type="email" 
                        required 
                        :tabindex="4" 
                        autocomplete="email" 
                        name="email" 
                        placeholder="email@example.com" 
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Student ID -->
                <div class="grid gap-2">
                    <Label for="studentId" class="text-sm font-medium text-foreground">Student ID</Label>
                    <Input 
                        id="studentId" 
                        type="text" 
                        :tabindex="5" 
                        name="studentId" 
                        placeholder="Enter student ID" 
                    />
                    <InputError :message="errors.studentId" />
                </div>

                <!-- Program + Year -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="program" class="text-sm font-medium text-foreground">Program</Label>
                        <Select name="program" :tabindex="6">
                            <SelectTrigger>
                                <SelectValue placeholder="Select program" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="Library and Information Science">Library and Information Science</SelectItem>
                                <SelectItem value="Computer Science">Computer Science</SelectItem>
                                <SelectItem value="Information System">Information System</SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="errors.program" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="year" class="text-sm font-medium text-foreground">Year Level</Label>
                        <Select name="year" :tabindex="7">
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
                        <InputError :message="errors.year" />
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid gap-2">
                    <Label for="password" class="text-sm font-medium text-foreground">Password</Label>
                    <Input 
                        id="password" 
                        type="password" 
                        required 
                        :tabindex="10" 
                        autocomplete="new-password" 
                        name="password" 
                        placeholder="Password" 
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-sm font-medium text-foreground">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="11"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <!-- Submit Button -->
                <Button type="submit" class="mt-2 w-full" :tabindex="12" :disabled="processing">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="13">Log in</TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
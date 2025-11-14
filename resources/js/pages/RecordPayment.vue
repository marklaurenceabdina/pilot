<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import type { BreadcrumbItem } from '@/types'

// shadcn-vue components
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectTrigger, SelectValue, SelectContent, SelectItem } from '@/components/ui/select'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Record Payment', href: '/payments/record' },
]

const form = useForm({
    date: new Date().toISOString().substr(0, 10),
    type: '',
    description: '',
    amount: 0,
})

const submitPayment = () => {
    form.post('/payments/record', {
        onSuccess: () => {
            alert('Payment recorded successfully!')
            form.reset()
            form.date = new Date().toISOString().substr(0, 10)
            form.type = ''
        },
    })
}
</script>

<template>

    <Head title="Record Payment" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-md mx-auto mt-10">
            <Card>
                <CardHeader>
                    <CardTitle class="text-center text-2xl font-semibold">Record Payment</CardTitle>
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submitPayment" class="space-y-5">
                        <!-- Category -->
                        <div>
                            <Label for="category">Category</Label>
                            <Select v-model="form.type" required>
                                <SelectTrigger id="category">
                                    <SelectValue placeholder="Select Category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Membership">Membership</SelectItem>
                                    <SelectItem value="Event Fee">Event Fee</SelectItem>
                                    <SelectItem value="Merchandise">Merchandise</SelectItem>
                                    <SelectItem value="Penalties">Penalties</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <!-- Description -->
                        <div>
                            <Label for="description">Description</Label>
                            <Input id="description" v-model="form.description" type="text"
                                placeholder="Payment description" required autocomplete="off" />
                        </div>

                        <!-- Amount -->
                        <div>
                            <Label for="amount">Amount</Label>
                            <Input id="amount" v-model.number="form.amount" type="number" placeholder="₱0.00"
                                required />
                        </div>

                        <!-- Hidden Date -->
                        <input type="hidden" v-model="form.date" />

                        <!-- Submit Button -->
                        <Button type="submit" class="w-full">
                            Record Payment
                        </Button>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

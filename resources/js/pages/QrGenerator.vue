<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import QrcodeVue from 'qrcode.vue'
import { ref } from 'vue'
import { Wallet } from 'lucide-vue-next'

// shadcn-vue components
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

// Selected payment method
const paymentMethod = ref<'gcash' | 'paymaya' | null>(null)
const amount = ref(0)

// QR strings
const gcashQR = '00020101021126650014com.gcash0111+639171234567...'
const paymayaQR = '00020101021126660014com.paymaya0111+639191234567...'

// Payment methods data
const methods = [
    { id: 'gcash', name: 'GCash', color: 'bg-blue-500', hover: 'hover:bg-blue-600', description: 'Scan to pay via GCash' },
    { id: 'paymaya', name: 'PayMaya', color: 'bg-green-500', hover: 'hover:bg-green-600', description: 'Scan to pay via PayMaya' },
]

// Form for submitting payment
const form = useForm({
    date: new Date().toISOString().substr(0, 10),
    type: '',
    description: '',
    amount: 0,
})

// Function to record payment
const recordPayment = () => {
    if (!paymentMethod.value) return alert('Please select a payment method')
    if (!amount.value || amount.value <= 0) return alert('Enter a valid amount')

    form.type = paymentMethod.value === 'gcash' ? 'GCash' : 'PayMaya'
    form.amount = amount.value
    form.description = `Payment via ${form.type}`

    form.post('/payments/record', {
        onSuccess: () => {
            alert('Payment recorded successfully!')
            amount.value = 0
            paymentMethod.value = null
            form.reset()
        },
    })
}
</script>

<template>

    <Head title="Payment QR Codes" />
    <AppLayout>
        <div class="p-6 space-y-8">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold">Choose Payment Method</h1>
                <p class="text-muted-foreground">Scan the QR code and record your payment.</p>
            </div>

            <!-- Payment Options -->
            <div class="grid gap-6 sm:grid-cols-2">
                <Card v-for="method in methods" :key="method.id" class="cursor-pointer transition-all hover:shadow-md"
                    :class="paymentMethod === method.id ? method.color + ' text-white' : ''"
                    @click="paymentMethod = method.id as 'gcash' | 'paymaya'">
                    <CardHeader>
                        <div class="flex items-center gap-3">
                            <Wallet class="h-6 w-6" />
                            <CardTitle>{{ method.name }}</CardTitle>
                        </div>
                        <CardDescription class="mt-2">{{ method.description }}</CardDescription>
                    </CardHeader>
                </Card>
            </div>

            <!-- QR Code Display + Amount -->
            <Card v-if="paymentMethod" class="rounded-2xl shadow-md">
                <CardHeader>
                    <CardTitle>
                        {{ paymentMethod === 'gcash' ? 'GCash QR Code' : 'PayMaya QR Code' }}
                    </CardTitle>
                    <CardDescription>
                        Scan this code with your {{ paymentMethod === 'gcash' ? 'GCash' : 'PayMaya' }} app to complete
                        the payment.
                    </CardDescription>
                </CardHeader>

                <CardContent class="flex flex-col items-center space-y-6">
                    <QrcodeVue :value="paymentMethod === 'gcash' ? gcashQR : paymayaQR" :size="180" class="mx-auto" />

                    <div class="flex items-center gap-2">
                        <div>
                            <Label for="amount">Amount</Label>
                            <Input id="amount" type="number" v-model.number="amount" placeholder="Enter amount"
                                class="w-40" />
                        </div>
                        <Button @click="recordPayment">Record Payment</Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { type BreadcrumbItem } from '@/types'
import AppLayout from '@/layouts/AppLayout.vue'

// lucide
import {
  BarChart,
  Users,
  UserCheck,
  UserX,
  Clock,
  HelpCircle,
  Share2,
  Download,
  Star,
  ThumbsUp,
  MessageSquare
} from 'lucide-vue-next'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Event Analytics', href: '/analytics' },
]

defineProps<{
  attendance: { registered: number; attended: number; no_shows: number }
  engagement: {
    sessionDuration: string; questionsAsked: number; networkingSessions: number; resourceDownloads: number
  }
  feedback: {
    overallRating: number; wouldRecommend: number; responses: number;
    recentFeedback: { rating: number; comment: string; time: string }[]
  }
}>()
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Event Analytics" />

    <div class="min-h-screen bg-gray-900 text-white p-8 space-y-6">
      <!-- Title + Export -->
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold flex items-center gap-2">
          <BarChart class="w-6 h-6 text-blue-400" /> Event Analytics
        </h1>

        <a
          href="/analytics/export"
          class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-500 px-4 py-2 text-sm font-medium"
        >
          <Download class="w-4 h-4" />
          Export
        </a>
      </div>

      <!-- Attendance -->
      <div class="bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold flex items-center gap-2 mb-4">
          <Users class="w-5 h-5 text-green-400" /> Attendance Overview
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
          <div>
            <UserCheck class="mx-auto w-6 h-6 text-green-400" />
            <p class="mt-2">Registered</p>
            <p class="text-green-400 font-bold">{{ attendance.registered }}</p>
          </div>
          <div>
            <Users class="mx-auto w-6 h-6 text-green-300" />
            <p class="mt-2">Attended</p>
            <p class="text-green-300 font-bold">{{ attendance.attended }}</p>
          </div>
          <div>
            <UserX class="mx-auto w-6 h-6 text-red-400" />
            <p class="mt-2">No-shows</p>
            <p class="text-red-400 font-bold">{{ attendance.no_shows }}</p>
          </div>
        </div>
      </div>

      <!-- Engagement -->
      <div class="bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold flex items-center gap-2 mb-4">
          <MessageSquare class="w-5 h-5 text-yellow-400" /> Engagement Metrics
        </h2>
        <ul class="space-y-3">
          <li class="flex justify-between items-center">
            <span class="flex items-center gap-2">
              <Clock class="w-5 h-5 text-blue-400" /> Session Duration
            </span>
            <span>{{ engagement.sessionDuration }}</span>
          </li>
          <li class="flex justify-between items-center">
            <span class="flex items-center gap-2">
              <HelpCircle class="w-5 h-5 text-purple-400" /> Questions Asked
            </span>
            <span>{{ engagement.questionsAsked }}</span>
          </li>
          <li class="flex justify-between items-center">
            <span class="flex items-center gap-2">
              <Share2 class="w-5 h-5 text-pink-400" /> Networking Sessions
            </span>
            <span>{{ engagement.networkingSessions }}</span>
          </li>
          <li class="flex justify-between items-center">
            <span class="flex items-center gap-2">
              <Download class="w-5 h-5 text-green-400" /> Resource Downloads
            </span>
            <span>{{ engagement.resourceDownloads }}</span>
          </li>
        </ul>
      </div>

      <!-- Feedback -->
      <div class="bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold flex items-center gap-2 mb-4">
          <Star class="w-5 h-5 text-yellow-400" /> Feedback Collection
        </h2>

        <div class="text-center mb-4">
          <p class="text-4xl font-bold text-green-400">{{ feedback.overallRating }}</p>
          <p class="text-yellow-400 flex justify-center">
            <Star class="w-5 h-5" v-for="i in 5" :key="i" />
          </p>
          <p class="mt-2 text-lg flex justify-center items-center gap-2">
            <ThumbsUp class="w-5 h-5 text-blue-400" />
            {{ feedback.wouldRecommend }}% Would Recommend
          </p>
          <p class="text-gray-400">{{ feedback.responses }} Responses</p>
        </div>

        <div>
          <h3 class="text-md font-semibold mb-2">Recent Feedback</h3>
          <div
            v-for="(f, idx) in feedback.recentFeedback"
            :key="idx"
            class="bg-gray-700 p-3 rounded-lg mb-3"
          >
            <p class="text-yellow-400 flex">
              <Star class="w-4 h-4" v-for="i in f.rating" :key="i" />
            </p>
            <p class="mt-1">"{{ f.comment }}"</p>
            <p class="text-sm text-gray-400 mt-1">{{ f.time }}</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
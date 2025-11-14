<!-- resources/js/components/AppLogoIcon.vue -->
<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

// Correct relative path from resources/js/components -> resources/assets/images
import HdPsitsLogo from '../../assets/images/hd-psits-logo.svg';

interface Props {
  className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
  <img
    :src="HdPsitsLogo"
    :class="className"
    alt="PSITS Nexus Logo"
    v-bind="$attrs"
  />
</template>

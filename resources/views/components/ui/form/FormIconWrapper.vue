<script setup lang="ts">
import { type HTMLAttributes } from 'vue'
import { cn } from '@/scripts/lib/utils'

const props = defineProps<{
    class?: HTMLAttributes['class']
}>()
</script>

<template>
    <span
        :class="cn(
     'absolute start-0 inset-y-0 flex items-center justify-center px-2',
      props.class,
    )">
        <slot />
    </span>
</template>

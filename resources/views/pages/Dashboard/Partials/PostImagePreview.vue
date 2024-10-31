<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { ImageIcon } from 'lucide-vue-next'

const props = defineProps<{
    // ...
}>()
</script>

<template>
    <figure class="hidden sm:block border rounded-lg size-14 flex-shrink-0 bg-muted text-muted-foreground">
        <Stack
            justify="center"
            items="center"
            class="w-full h-full"
        >
            <ImageIcon class="size-5" />
        </Stack>
    </figure>
</template>

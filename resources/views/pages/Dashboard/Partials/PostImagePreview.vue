<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { ImageIcon } from 'lucide-vue-next'

const props = defineProps<{
    post: App.Models.Post
}>()
</script>

<template>
    <figure
        class="hidden sm:block border rounded-lg size-14 flex-shrink-0"
        :class="props.post.id === 0 ? '' : 'bg-muted text-muted-foreground'"
    >
        <Stack
            v-if="props.post.id !== 0"
            justify="center"
            items="center"
            class="w-full h-full"
        >
            <ImageIcon class="size-5" />
        </Stack>

        <img
            v-else
            :src="props.post.id"
            :alt="props.post.title"
            class="w-full h-full object-cover rounded-lg"
        />
    </figure>
</template>

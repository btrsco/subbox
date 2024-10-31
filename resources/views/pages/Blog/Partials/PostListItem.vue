<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { ImageIcon } from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3'
import { useDayjs } from '@/scripts/lib/dayjs'
import { getLocalTimeZone } from '@internationalized/date'
import { route } from 'ziggy-js'

const props = defineProps<{
    blogSlug: string
    post: App.Models.Post
    userName: string
}>()

const dayjs = useDayjs(getLocalTimeZone())
</script>

<template>
    <Stack
        direction="row"
        items="center"
        class="group gap-4 py-4 sm:py-8 border-b"
    >
        <Stack
            :as="Link"
            :href="route('blog.posts.show', { blog: props.blogSlug, post: props.post.slug })"
            class="gap-1"
        >
            <h2 class="text-lg font-bold group-hover:text-accent-500">
                {{ props.post.title }}
            </h2>
            <p class="line-clamp-2">
                {{ props.post.content }}
            </p>
            <p class="text-xs text-muted-foreground font-semibold tracking-wide uppercase">
                {{ dayjs(props.post.published_at).format('MMM D, YYYY') }} &middot; {{ props.userName }}
            </p>
        </Stack>

        <Stack
            :as="Link"
            :href="route('blog.posts.show', { blog: props.blogSlug, post: props.post.slug })"
            class="aspect-[4/3] border bg-muted text-muted-foreground rounded-lg overflow-hidden flex-shrink-0 min-h-32"
        >
            <Stack
                justify="center"
                items="center"
                class="w-full h-full"
            >
                <ImageIcon class="size-5" />
            </Stack>
        </Stack>
    </Stack>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import PostImagePreview from '@/views/pages/Dashboard/Partials/PostImagePreview.vue'
import { useDayjs } from '@/scripts/lib/dayjs'
import PostInteractionDropdown from '@/views/pages/Dashboard/Partials/PostInteractionDropdown.vue'
import { ArrowUpRightIcon } from 'lucide-vue-next'

const props = defineProps<{
    post: App.Models.Post
    noImage?: boolean
}>()

const $page = usePage()
const dayjs = useDayjs()
const blog = $page.props.auth.blog

const postStatusLabel = (post: App.Models.Post) => {
    if (post.status === 'draft') {
        return 'Last Updated'
    }

    if (post.status === 'scheduled') {
        return 'Scheduled For'
    }

    return 'Published'
}

</script>

<template>
    <Stack
        direction="row"
        justify="between"
        items="center"
        as="li"
        class="w-full py-4 sm:px-2 border-b hover:bg-muted/50 last-of-type:border-b-0"
    >
        <Stack
            direction="row"
            items="center"
            class="w-full gap-4"
            :as="Link"
            :href="route('dashboard.posts.edit', { post: post.id })"
        >
            <PostImagePreview v-if="!props.noImage" />

            <Stack
                class="w-full"
                wrap="wrap"
            >
                <div class="text-sm font-semibold sm:line-clamp-1">
                    {{ post.title }}
                </div>
                <div class="text-[0.625rem] uppercase font-semibold text-muted-foreground tracking-wide">
                    {{ postStatusLabel(post) }}
                    {{ dayjs(post.published_at ?? post.updated_at).format('MMM D, YYYY') }}
                </div>
            </Stack>
        </Stack>

        <Stack
            direction="row"
            items="center"
            class="gap-2"
        >
            <Button
                v-if="post.status === 'published'"
                :as="Link"
                :href="route('blog.posts.show', { blog: blog?.slug, post: post.slug })"
                variant="outline"
                size="icon-sm"
                class="text-muted-foreground"
            >
                <ArrowUpRightIcon class="size-4" />
            </Button>

            <PostInteractionDropdown :post="post" />
        </Stack>

    </Stack>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ArrowUpRightIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { PostPagination } from '@/types'
import { useDayjs } from '@/scripts/lib/dayjs'
import PostInteractionDropdown from '@/views/pages/Dashboard/Partials/PostInteractionDropdown.vue'
import PostImagePreview from '@/views/pages/Dashboard/Partials/PostImagePreview.vue'
import { computed } from 'vue'
import PostListItem from '@/views/pages/Dashboard/Partials/PostListItem.vue'

const props = defineProps<{
    posts: PostPagination
    noImage?: boolean
}>()
</script>

<template>
    <Stack
        as="ul"
        class="w-full"
    >
        <PostListItem
            v-for="post in props.posts.data"
            :key="post.id"
            :post="post"
            :no-image="props.noImage"
        />
    </Stack>
</template>

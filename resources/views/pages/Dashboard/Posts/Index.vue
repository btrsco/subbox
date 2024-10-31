<script setup lang="ts">
import DashboardLayout from '@/views/layouts/DashboardLayout.vue'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import { Button } from '@/views/components/ui/button'
import { Stack } from '@/views/components/bespoke/stack'
import { PostCounts, PostOrder, PostPagination, PostStatus } from '@/types'
import PostStatusTabs from '@/views/pages/Dashboard/Partials/PostStatusTabs.vue'
import PostOrderDropdown from '@/views/pages/Dashboard/Partials/PostOrderDropdown.vue'
import { TextSelectIcon } from 'lucide-vue-next'
import EmptyState from '@/views/pages/Dashboard/Partials/EmptyState.vue'
import MiniPagination from '@/views/pages/Dashboard/Partials/MiniPagination.vue'
import PostList from '@/views/pages/Dashboard/Partials/PostList.vue'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps<{
    selectedStatus: PostStatus
    selectedOrder: PostOrder
    posts: PostPagination
    postCounts: PostCounts
}>()

const selectedStatusLabel = computed(() => {
    switch (props.selectedStatus) {
        case 'published':
            return 'published'
        case 'draft':
            return 'draft'
        case 'scheduled':
            return 'scheduled'
    }
})
</script>

<template>
    <DashboardLayout title="Posts">
        <DashboardPageHeading heading="Posts">
            <template #actions>
                <Stack
                    direction="row"
                    class="gap-2"
                >
                    <Button
                        :as="Link"
                        :href="route('dashboard.posts.create')"
                        variant="accent"
                    >
                        New post
                    </Button>
                </Stack>
            </template>
        </DashboardPageHeading>

        <Stack
            class="flex-col sm:flex-row justify-between items-end gap-4"
        >
            <PostStatusTabs
                :selected-status="props.selectedStatus"
                :selected-order="props.selectedOrder"
                :post-counts="props.postCounts"
            />

            <PostOrderDropdown
                :selected-status="props.selectedStatus"
                :selected-order="props.selectedOrder"
            />
        </Stack>

        <Stack>
            <template v-if="props.posts.data.length > 0">
                <PostList
                    :posts="props.posts"
                    class="border-y"
                />
            </template>
            <template v-else>
                <EmptyState
                    :icon="TextSelectIcon"
                    actionLabel="New post"
                    :actionHref="route('dashboard.posts.create')"
                >
                    <p>
                        You don't have any
                        {{ selectedStatusLabel }}
                        posts yet!
                    </p>
                </EmptyState>
            </template>
        </Stack>

        <MiniPagination :pagination="props.posts" />
    </DashboardLayout>
</template>

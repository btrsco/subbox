<script setup lang="ts">
import { Badge } from '@/views/components/ui/badge'
import { Tabs, TabsList, TabsTrigger } from '@/views/components/ui/tabs'
import { Link } from '@inertiajs/vue3'
import { PostCounts, PostOrder, PostStatus } from '@/types'

const props = defineProps<{
    selectedStatus: PostStatus
    selectedOrder: PostOrder
    postCounts: PostCounts
}>()
</script>

<template>
    <Tabs
        :default-value="props.selectedStatus"
        class="w-full sm:w-auto"
    >
        <TabsList class="justify-start w-full sm:w-auto">
            <TabsTrigger
                value="published"
                class="p-0"
                as-child
            >
                <Link
                    :href="route('dashboard.posts.index', {status: 'published', order: props.selectedOrder})"
                    class="px-3 py-1"
                >
                    Published
                    <Badge
                        v-if="props.postCounts.published > 0"
                        :variant="props.selectedStatus === 'published' ? 'default' : 'gray'"
                        class="ml-1"
                    >
                        {{ props.postCounts.published }}
                    </Badge>
                </Link>
            </TabsTrigger>
            <TabsTrigger
                value="draft"
                class="p-0"
                as-child
            >
                <Link
                    :href="route('dashboard.posts.index', {status: 'draft', order: props.selectedOrder})"
                    class="px-3 py-1"
                >
                    Drafts
                    <Badge
                        v-if="props.postCounts.drafts > 0"
                        :variant="props.selectedStatus === 'draft' ? 'default' : 'gray'"
                        class="ml-1"
                    >
                        {{ props.postCounts.drafts }}
                    </Badge>
                </Link>
            </TabsTrigger>
            <TabsTrigger
                value="scheduled"
                class="p-0"
                as-child
            >
                <Link
                    :href="route('dashboard.posts.index', {status: 'scheduled', order: props.selectedOrder})"
                    class="px-3 py-1"
                >
                    Scheduled
                    <Badge
                        v-if="props.postCounts.scheduled > 0"
                        :variant="props.selectedStatus === 'scheduled' ? 'default' : 'gray'"
                        class="ml-1"
                    >
                        {{ props.postCounts.scheduled }}
                    </Badge>
                </Link>
            </TabsTrigger>
        </TabsList>
    </Tabs>
</template>

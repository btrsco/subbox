<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuCheckboxItem,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { ArrowDownWideNarrowIcon } from 'lucide-vue-next'
import { PostStatus, PostOrder } from '@/types'
import { computed, ref } from 'vue'

const props = defineProps<{
    selectedStatus: PostStatus
    selectedOrder: PostOrder
}>();

const orderLabel = computed(() => {
    switch (props.selectedOrder) {
        case 'newest':
            return 'Newest'
        case 'oldest':
            return 'Oldest'
        case 'updated':
            return 'Recently updated'
        case 'title':
            return 'Title'
    }
})

const orderedBy = ref({
    newest: props.selectedOrder === 'newest',
    oldest: props.selectedOrder === 'oldest',
    updated: props.selectedOrder === 'updated',
    title: props.selectedOrder === 'title'
})
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger>
            <Button variant="secondary">
                <ArrowDownWideNarrowIcon class="size-4 mr-2" />
                {{ orderLabel }}
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuCheckboxItem
                v-model:checked="orderedBy.newest"
                :as="Link"
                :href="route('dashboard.posts.index', {status: props.selectedStatus, order: 'newest'})"
            >
                Newest
            </DropdownMenuCheckboxItem>
            <DropdownMenuCheckboxItem
                v-model:checked="orderedBy.oldest"
                :as="Link"
                :href="route('dashboard.posts.index', {status: props.selectedStatus, order: 'oldest'})"
            >
                Oldest
            </DropdownMenuCheckboxItem>
            <DropdownMenuCheckboxItem
                v-model:checked="orderedBy.updated"
                :as="Link"
                :href="route('dashboard.posts.index', {status: props.selectedStatus, order: 'updated'})"
            >
                Recently updated
            </DropdownMenuCheckboxItem>
            <DropdownMenuCheckboxItem
                v-model:checked="orderedBy.title"
                :as="Link"
                :href="route('dashboard.posts.index', {status: props.selectedStatus, order: 'title'})"
            >
                Title
            </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>

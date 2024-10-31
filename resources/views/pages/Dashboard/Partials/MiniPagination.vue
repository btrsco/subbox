<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { Pagination } from '@/types'

const props = defineProps<{
    pagination: Pagination
    align?: 'start' | 'center' | 'end'
}>()
</script>

<template>
    <Stack
        direction="row"
        :justify="props.align ?? 'end'"
        class="w-full"
    >
        <Stack
            direction="row"
            items="center"
            class="gap-2 text-muted-foreground text-xs"
        >
            <component
                :is="props.pagination.prev_page_url ? Link: 'div'"
                :href="props.pagination.prev_page_url ?? ''"
                class="p-2"
                :class="!props.pagination.prev_page_url ? 'cursor-not-allowed opacity-25' : ''"
            >
                <ChevronLeftIcon class="size-5" />
            </component>

            <span>{{ props.pagination.from ?? 0 }} - {{ props.pagination.to ?? 0 }} of {{ props.pagination.total }}</span>

            <component
                :is="props.pagination.next_page_url ? Link: 'div'"
                :href="props.pagination.next_page_url ?? ''"
                class="p-2"
                :class="!props.pagination.next_page_url ? 'cursor-not-allowed opacity-25' : ''"
            >
                <ChevronRightIcon class="size-5" />
            </component>
        </Stack>
    </Stack>
</template>

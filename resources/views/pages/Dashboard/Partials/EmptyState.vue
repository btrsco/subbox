<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { type Component } from 'vue'

const props = defineProps<{
    icon?: string | Component
    actionLabel?: string
    actionHref?: string
}>()
</script>

<template>
    <Stack
        justify="center"
        items="center"
        class="px-4 py-8 w-full border rounded-lg bg-muted text-muted-foreground text-center text-sm gap-4"
    >
        <Stack
            v-if="props.icon"
            justify="center"
            items="center"
            class="rounded-full border bg-background size-12 text-muted-foreground"
        >
            <component
                :is="props.icon"
                class="size-5"
            />
        </Stack>

        <slot />

        <Button
            v-if="actionLabel && actionHref"
            variant="outline"
            size="sm"
            as-child
        >
            <Link :href="actionHref">
                {{ actionLabel }}
            </Link>
        </Button>
    </Stack>
</template>

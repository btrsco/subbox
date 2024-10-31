<script setup lang="ts">
import { ArrowRightIcon, CheckIcon, CircleIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'

const props = defineProps<{
    label: string
    completed: boolean
    href?: string
}>()
</script>

<template>
    <Stack
        :as="props.completed ? 'div' : 'a'"
        :href="props.href ?? '#'"
        direction="row"
        justify="between"
        items="center"
        class="px-4 py-3 rounded-md border w-full"
        :class="props.completed ? 'opacity-75 bg-muted text-muted-foreground' : 'bg-background text-primary'"
    >
        <Stack
            direction="row"
            items="center"
            class="gap-2 text-sm font-bold"
        >
            <CheckIcon
                v-if="completed"
                class="size-4 text-muted-foreground"
            />
            <CircleIcon
                v-else
                class="size-4 text-muted-foreground"
            />

            {{ props.label }}
        </Stack>

        <ArrowRightIcon class="size-4 text-muted-foreground" />
    </Stack>
</template>

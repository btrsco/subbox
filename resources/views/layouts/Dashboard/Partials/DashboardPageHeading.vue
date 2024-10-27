<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { Badge } from '@/views/components/ui/badge'
import { type Component } from 'vue'

const props = defineProps<{
    heading?: string
    subheading?: string
    icon?: string | Component
    count?: number
}>()
</script>

<template>
    <Stack
        as="header"
        v-if="props.heading || props.subheading || $slots.details"
        direction="row"
        class="w-full gap-2"
    >

        <Stack
            v-if="props.icon"
            justify="center"
            align="center"
            class="size-6 sm:size-8 rounded-md border mt-0.5 sm:mt-0 lg:mt-0.5 overflow-hidden"
        >
            <img
                v-if="typeof props.icon === 'string'"
                :src="props.icon"
                :alt="props.heading + ' icon'"
                class="w-full h-full object-cover"
            />
            <component
                v-else
                :is="props.icon"
                class="size-4 text-muted-foreground"
            />
        </Stack>

        <Stack as="hgroup" class="gap-1">
            <Stack as="h1" direction="row" align="center" class="gap-2">
                <span class="text-xl sm:text-2xl lg:text-3xl font-semibold tracking-tight">{{ props.heading }}</span>
                <Badge v-if="props.count" variant="outline" class="text-sm lg:text-base px-2">{{ props.count }}</Badge>

                <aside v-if="$slots.details" class="ml-6">
                    <slot name="details" />
                </aside>
            </Stack>

            <h2 v-if="props.subheading" class="text-sm text-muted-foreground">
                {{ props.subheading }}
            </h2>
        </Stack>

    </Stack>
</template>

<style scoped>

</style>

<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { Link } from '@inertiajs/vue3'
import { QuestionMarkCircledIcon, ArrowRightIcon } from '@radix-icons/vue'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/views/components/ui/tooltip'

const props = defineProps<{
    title: string
    tooltip?: string
    actionLabel?: string
    actionHref?: string
}>()
</script>

<template>
    <Stack
        direction="row"
        justify="between"
        items="center"
        class="w-full"
    >
        <Stack
            direction="row"
            items="center"
            class="font-semibold text-lg sm:text-xl mr-auto"
        >
            {{ props.title }}

            <TooltipProvider v-if="props.tooltip">
                <Tooltip :delay-duration="100">
                    <TooltipTrigger>
                        <QuestionMarkCircledIcon class="size-4 ml-2"/>
                    </TooltipTrigger>
                    <TooltipContent>
                        {{ props.tooltip }}
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>
        </Stack>

        <Stack
            v-if="props.actionLabel && props.actionHref"
            :as="Link"
            :href="props.actionHref"
            direction="row"
            class="gap-2 text-xs font-medium text-muted-foreground hover:text-primary cursor-pointer"
        >
            {{ props.actionLabel }}
            <ArrowRightIcon class="size-4" />
        </Stack>
    </Stack>
</template>

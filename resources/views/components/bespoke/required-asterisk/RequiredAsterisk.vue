<script setup lang="ts">
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/views/components/ui/tooltip'

const props = withDefaults(defineProps<{
    tooltip?: string
}>(), {
    tooltip: 'Required'
})
</script>

<template>
    <TooltipProvider>
        <Tooltip :delay-duration="0">
            <TooltipTrigger>
                <span class="text-destructive">*</span>
            </TooltipTrigger>
            <TooltipContent>
                <span class="text-sm">{{ tooltip }}</span>
            </TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>

<script setup lang="ts">
import { Separator } from '@/views/components/ui/separator'
import { Stack } from '@/views/components/bespoke/stack'
import { cn } from '@/scripts/lib/utils'
import { textSeparatorVariants, TextSeparatorVariants } from '@/views/components/bespoke/text-separator'

const props = defineProps<{
    text: string;
    size?: TextSeparatorVariants['size'];
}>()
</script>

<template>
    <Stack direction="row" justify="center" items="center" class="relative w-full gap-3">
        <Separator class="flex-1" />
        <div :class="cn(textSeparatorVariants({size}), 'text-muted-foreground')">{{ text }}</div>
        <Separator class="flex-1" />
    </Stack>
</template>

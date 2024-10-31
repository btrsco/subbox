<script setup lang="ts">
import { type Component, type HTMLAttributes } from 'vue'
import { stackVariants, StackVariants } from '@/views/components/bespoke/stack'
import { cn } from '@/scripts/lib/utils'
import { AsTag } from '@/types'

const props = withDefaults(defineProps<{
    class?: HTMLAttributes['class'];
    as?: AsTag | Component;
    direction?: StackVariants['direction'];
    items?: StackVariants['items'];
    justify?: StackVariants['justify'];
    wrap?: StackVariants['wrap'];
    block?: boolean;
}>(), {
    as: 'div',
})
</script>

<template>
    <component
        :is="props.as"
        :class="cn(stackVariants({direction, items, justify, wrap}), props.class ?? '', {'w-full': props.block})"
    >
        <slot />
    </component>
</template>

<style scoped>

</style>

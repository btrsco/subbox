<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { Primitive, type PrimitiveProps } from 'radix-vue'
import { type ButtonVariants, buttonVariants } from '.'
import { cn } from '@/scripts/lib/utils'

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant']
    size?: ButtonVariants['size']
    class?: HTMLAttributes['class']
    block?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    as: 'button',
})

const blockClass = props.block ? 'w-full' : ''
</script>

<template>
    <Primitive
        :as="as"
        :as-child="asChild"
        :class="cn(buttonVariants({ variant, size }), props.class + ' ' + blockClass)"
    >
        <slot />
    </Primitive>
</template>

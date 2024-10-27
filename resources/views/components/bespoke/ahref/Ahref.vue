<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { cn } from '@/scripts/lib/utils'
import { AhrefVariants, ahrefVariants } from '@/views/components/bespoke/ahref'
import type { HTMLAttributes } from 'vue'

const props = withDefaults(defineProps<{
    route?: string & {}
    as?: string
    class?: HTMLAttributes['class']
    target?: '_blank' | '_self' | '_parent' | '_top'
    method?: 'get' | 'post' | 'put' | 'patch' | 'delete'
    rel?: string
    title?: string
    ariaLabel?: string
    ariaCurrent?: string
    variant?: AhrefVariants['variant']
    size?: AhrefVariants['size']
    underline?: boolean
}>(), {
    as: 'a',
    method: 'get',
    underline: true,
})

const href = props.route ? route(props.route) : '#'
</script>

<template>
    <Link
        :href="href"
        :as="props.as"
        :class="cn(ahrefVariants({variant, size, underline}), props.class)"
        :method="props.method"
        :target="props.target"
        :rel="props.rel"
        :title="props.title"
        :aria-label="props.ariaLabel"
        :aria-current="props.ariaCurrent"
    >
        <slot />
    </Link>
</template>

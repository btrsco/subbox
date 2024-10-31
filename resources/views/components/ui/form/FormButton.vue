<script setup lang="ts">
import type { PrimitiveProps } from 'radix-vue'
import { type Component, type HTMLAttributes } from 'vue'
import { Button, ButtonVariants } from '@/views/components/ui/button'
import { useForm } from '@inertiajs/vue3'
import { cn } from '@/scripts/lib/utils'
import { AsTag } from '@/types'

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: HTMLAttributes['class'];
    block?: boolean;
    route: string;
    data?: object;
    as?: AsTag | Component;
}

const props = withDefaults(defineProps<Props & { class?: HTMLAttributes['class'] }>(), {
    as: 'button',
})

const form = useForm(props.data || {})

const onSubmit = () => {
    form.post(route(props.route))
}
</script>

<template>
    <Button
        @click="onSubmit"
        :as="props.as"
        :as-child="props.asChild"
        :class="cn('', props.class)"
        :variant="props.variant"
        :size="props.size"
        :block="props.block"
        :disabled="form.processing">
        <slot />
    </Button>
</template>

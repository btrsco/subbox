<script lang="ts" setup>
import { Slot } from 'radix-vue'
import { useFormField } from './useFormField'
import { type Component, computed } from 'vue'
import { AsTag } from '@/types'

const { error, formItemId, formDescriptionId, formMessageId } = useFormField()

const props = defineProps<{
    as?: AsTag | Component;
}>()

const asComponent = computed(() => props.as || Slot)
</script>

<template>
    <component
        :is="asComponent"
        :id="formItemId"
        :aria-describedby="!error ? `${formDescriptionId}` : `${formDescriptionId} ${formMessageId}`"
        :aria-invalid="!!error"
    >
        <slot />
    </component>
</template>

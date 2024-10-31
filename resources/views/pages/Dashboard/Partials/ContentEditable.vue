<script setup lang="ts">
import { computed, ref, watch } from 'vue'

const props = defineProps<{
    modelValue?: string
    content?: string
    placeholder?: string
    multiline?: boolean
}>()

const emits = defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

const isEditing = ref(false)
const isEmpty = computed(() => !props.modelValue);
const contentEditableElement = ref<HTMLDivElement | null>(null)

const onInput = (event: Event) => {
    const target = event.target as HTMLDivElement

    emits('update:modelValue', target.innerText.trim())
}

const handleMultiline = (event: KeyboardEvent) => {
    if (!props.multiline && event.key === 'Enter') {
        event.preventDefault()
    }
};

watch(
    () => props.modelValue,
    (newValue) => {
        if (!isEditing.value && contentEditableElement.value) {
            const currentContent = contentEditableElement.value.innerText.trim()

            if (currentContent !== newValue?.trim()) {
                contentEditableElement.value.innerText = newValue?.trim() || ''
            }
        }
    }
);
</script>

<template>
    <div class="relative w-full p-0">
        <span v-if="isEmpty" class="absolute pointer-events-none text-muted-foreground">
            {{ props.placeholder }}
        </span>

        <div
            class="relative w-full h-full p-0 focus:outline-none focus:ring-0"
            contenteditable="true"
            ref="contentEditableElement"
            @focus="isEditing = true"
            @blur="isEditing = false"
            @input="onInput"
            @keydown="handleMultiline"
        >
            {{ props.modelValue }}
        </div>
    </div>
</template>

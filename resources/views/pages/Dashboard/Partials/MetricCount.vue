<script setup lang="ts">
const props = defineProps<{
    label: string
    count?: number
}>()
</script>

<template>
    <div class="rounded-xl border bg-card text-card-foreground col-span-1 p-4">
        <div class="text-sm font-semibold text-muted-foreground">
            {{ props.label }}
        </div>
        <div class="text-4xl font-bold">
            {{ props.count || 0 }}
        </div>
    </div>
</template>

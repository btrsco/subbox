<script setup lang="ts">
import ThemeToggleTrigger from '@/views/components/bespoke/theme-toggle/ThemeToggleTrigger.vue'
import { Button, type ButtonVariants } from '@/views/components/ui/button'
import { SunIcon, MoonIcon, MonitorIcon } from 'lucide-vue-next'

const props = withDefaults(defineProps<{
    variant?: ButtonVariants['variant']
    size?: ButtonVariants['size']
}>(), {
    variant: 'outline',
    size: 'icon-sm',
})
</script>

<template>
    <ThemeToggleTrigger v-slot="{ currentTheme }" tooltip>
        <Button
            :variant="props.variant"
            :size="props.size"
            class="text-muted-foreground"
        >
            <template v-if="!$slots.default">
                <SunIcon v-if="currentTheme === 'light'"
                         class="w-4 h-4" />
                <MoonIcon v-if="currentTheme === 'dark'"
                          class="w-4 h-4" />
                <MonitorIcon v-if="currentTheme === 'system'"
                             class="w-4 h-4" />
            </template>
            <slot v-else />
        </Button>
    </ThemeToggleTrigger>
</template>

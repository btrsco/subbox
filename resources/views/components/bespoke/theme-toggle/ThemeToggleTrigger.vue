<script setup lang="ts">
import { ref, computed, type Component } from 'vue'
import { Tooltip, TooltipTrigger, TooltipProvider, TooltipContent } from '@/views/components/ui/tooltip'
import { Theme } from '@/types'

const props = withDefaults(defineProps<{
    as?: string | Component
    asChild?: boolean
    tooltip?: boolean
    tooltipSide?: 'top' | 'right' | 'bottom' | 'left'
    tooltipSideOffset?: number
    tooltipAlign?: 'start' | 'center' | 'end'
    tooltipAlignOffset?: number
}>(), {
    tooltipSide: 'top',
    tooltipAlign: 'center',
})

const currentTheme = ref<Theme>('system')

const currentThemeLabel = computed(() => {
    return {
        'dark':   'Dark mode',
        'light':  'Light mode',
        'system': 'System mode',
    }[currentTheme.value]
})

const nextTheme = computed(() => {
    return {
        'dark':   'light',
        'light':  'system',
        'system': 'dark',
    }[currentTheme.value] as Theme
})

const nextThemeLabel = computed(() => {
    return {
        'dark':   'Light mode',
        'light':  'System mode',
        'system': 'Dark mode',
    }[currentTheme.value]
})

const setTheme = (theme: Theme) => {
    currentTheme.value = theme
    localStorage.setItem('theme', theme)

    const isDarkMode = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)
    document.body.classList.toggle('dark', isDarkMode)
}

const toggleTheme = () => {
    setTheme(nextTheme.value)
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    const isDarkMode = event.matches
    document.body.classList.toggle('dark', isDarkMode)
})

setTheme(localStorage.getItem('theme') as Theme ?? 'system')
</script>

<template>
    <TooltipProvider>

        <Tooltip :delay-duration="100" :disableClosingTrigger="true">

            <TooltipTrigger
                :as="props.as"
                :as-child="props.asChild"
                @click="toggleTheme"
            >
                <slot
                    :currentTheme="currentTheme"
                    :currentThemeLabel="currentThemeLabel"
                    :nextTheme="nextTheme"
                    :nextThemeLabel="nextThemeLabel"
                />
            </TooltipTrigger>

            <TooltipContent
                v-if="props.tooltip"
                :side="props.tooltipSide"
                :side-offset="props.tooltipSideOffset"
                :align="props.tooltipAlign"
                :align-offset="props.tooltipAlignOffset"
            >
                Theme: {{ currentThemeLabel }}
            </TooltipContent>

        </Tooltip>

    </TooltipProvider>
</template>

<script setup lang="ts">
import PageHead from '@/views/components/utils/PageHead.vue'
import { OnboardingLayout } from '@/types/layouts'
import { BookmarkIcon, ChevronLeftIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'

const props = defineProps<OnboardingLayout>()
</script>

<template>
    <PageHead :title="title" />

    <Stack
        as="header"
        direction="row"
        align="center"
        class="hidden md:flex gap-4 p-4"
    >
        <Button
            as="a"
            variant="outline"
            size="icon-xs"
            :href="route('home')"
        >
            <ChevronLeftIcon class="size-4 text-muted-foreground"></ChevronLeftIcon>
        </Button>
        <BookmarkIcon class="size-6 text-accent-foreground"></BookmarkIcon>
    </Stack>

    <Stack
        as="main"
        align="center"
        class="w-full min-h-screen p-4 gap-4"
    >
        <slot />
    </Stack>
</template>

<style lang="scss">
body {
    @apply bg-muted/75;
}
</style>

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

    <Stack class="bg-muted/50">
        <Stack
            as="header"
            direction="row"
            items="center"
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
            <BookmarkIcon class="size-6 text-accent"></BookmarkIcon>
        </Stack>

        <Stack
            as="main"
            items="center"
            class="w-full min-h-screen p-4 gap-4"
        >
            <slot />
        </Stack>
    </Stack>
</template>

<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { BookmarkIcon } from 'lucide-vue-next'
import { Button } from '@/views/components/ui/button'
import { Link, usePage } from '@inertiajs/vue3'
import PageHead from '@/views/components/utils/PageHead.vue'

const $page = usePage()
const app = $page.props.app
</script>

<template>
    <PageHead title="Home for your thoughts" />
    <Stack
        class="w-full min-h-screen bg-muted/50"
    >
        <Stack
            direction="row"
            justify="between"
            items="center"
            class="p-4 w-full"
        >
            <BookmarkIcon class="size-6 text-accent"></BookmarkIcon>

            <Stack
                direction="row"
                class="gap-2"
            >
                <Button
                    :as="Link"
                    :href="route('register')"
                    variant="accent"
                    size="sm"
                >
                    Start publishing
                </Button>
                <Button
                    :as="Link"
                    :href="route('login')"
                    variant="outline"
                    size="sm"
                >
                    Log in
                </Button>
            </Stack>
        </Stack>

        <Stack
            justify="center"
            items="center"
            class="w-full min-h-[calc(100vh_-_theme(spacing.16)_-_theme(spacing.10))] gap-8"
        >
            <h1 class="text-4xl sm:text-5xl md:text-6xl text-accent font-serif w-full max-w-lg text-center">
                The home for all of your thoughts
            </h1>

            <Stack
                direction="row"
                class="gap-4"
            >
                <Button
                    :as="Link"
                    :href="route('register')"
                    variant="accent"
                    size="lg"
                >
                    Create your {{ app.name }}
                </Button>
                <Button
                    :as="Link"
                    :href="route('login')"
                    variant="outline"
                    size="lg"
                >
                    Log in
                </Button>
            </Stack>
        </Stack>
    </Stack>
</template>

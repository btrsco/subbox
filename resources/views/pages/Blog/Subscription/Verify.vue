<script setup lang="ts">
import { url } from '@/scripts/lib/url'
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { ChevronRightIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { Avatar, AvatarFallback, AvatarImage } from '@/views/components/ui/avatar'
import PageHead from '@/views/components/utils/PageHead.vue'

const props = defineProps<{
    blog: App.Models.Blog
}>()
</script>

<template>
    <PageHead :title="'Email verified - ' + props.blog.name" />

    <Stack
        justify="center"
        items="center"
        class="fixed z-40 inset-0 bg-background"
    >

        <Stack
            items="center"
            class="gap-8 w-full max-w-sm p-4"
        >
            <Avatar
                shape="square"
                class="size-20 cursor-pointer"
            >
                <AvatarImage
                    :src="url('/images/blog-placeholder.jpg')"
                    :alt="props.blog.name"
                />
                <AvatarFallback>{{ props.blog.initials }}</AvatarFallback>
            </Avatar>

            <Stack class="gap-4">
                <h1 class="text-2xl font-bold text-center w-full">
                    Email verified!
                </h1>
                <p class="text-center">
                    You're now subscribed to {{ props.blog.name }}.
                </p>
            </Stack>

            <Button
                :as="Link"
                :href="route('blog.index', { blog: props.blog.slug })"
                variant="accent"
            >
                View blog
                <ChevronRightIcon class="size-4 ml-2"/>
            </Button>
        </Stack>
    </Stack>
</template>

<style scoped>

</style>

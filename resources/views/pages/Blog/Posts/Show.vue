<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import BlogLayout from '@/views/layouts/BlogLayout.vue'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import { route } from 'ziggy-js'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Card } from '@/views/components/ui/card'
import { url } from '@/scripts/lib/url'
import { Avatar, AvatarImage, AvatarFallback } from '@/views/components/ui/avatar'
import { Button } from '@/views/components/ui/button'
import { useDayjs } from '@/scripts/lib/dayjs'
import { getLocalTimeZone } from '@internationalized/date'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import { ref } from 'vue'
import { useClipboard } from '@vueuse/core'
import SubscriptionInput from '@/views/pages/Blog/Partials/SubscriptionInput.vue'
import { Separator } from '@/views/components/ui/separator'

const props = defineProps<{
    emailVerified: boolean
    blog: App.Models.Blog
    post: App.Models.Post
    user: App.Models.User
    status?: string
}>()

const dayjs = useDayjs(getLocalTimeZone())

const publicPostLink = ref(route('blog.posts.show', {
    blog: props.blog.slug,
    post: props.post.slug
}))

const {copy, copied, isSupported} = useClipboard({source: publicPostLink.value})

const paragraphs = props.post.content?.split('\n\n')
</script>

<template>
    <BlogLayout
        :email-verified="props.emailVerified"
        :first-visit="false"
        :title="props.post.title + ' - ' + props.blog.name"
        :blog="props.blog"
        :status="props.status"
    >
        <Stack class="gap-3 w-full pb-8 border-b">
            <hgroup class="w-full space-y-2">
                <h1 class="text-3xl font-bold tracking-tight">
                    {{ props.post.title }}
                </h1>
                <h2
                    v-if="props.post.subtitle"
                    class="text-lg tracking-tight text-muted-foreground"
                >
                    {{ props.post.subtitle }}
                </h2>
            </hgroup>
            <Stack
                direction="row"
                items="center"
                class="gap-4 w-full"
            >
                <Avatar
                    shape="circle"
                    class="size-10 cursor-pointer"
                >
                    <AvatarImage
                        :src="url('/images/user-placeholder.jpg')"
                        :alt="props.user.name"
                    />
                    <AvatarFallback>{{ props.user.initials }}</AvatarFallback>
                </Avatar>

                <Stack
                    direction="row"
                    justify="between"
                    items="center"
                    class="w-full"
                >
                    <Stack>
                        <p class="text-sm font-medium">
                            {{ props.user.name }}
                        </p>
                        <p class="text-[0.625rem] font-semibold tracking-wide text-muted-foreground uppercase">
                            {{ dayjs().format('MMM D, YYYY') }}
                        </p>
                    </Stack>

                    <Stack
                        direction="row"
                        class="gap-2"
                    >
                        <DropdownMenu v-if="isSupported">
                            <DropdownMenuTrigger as-child>
                                <Button variant="outline">
                                    Share
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem @click="copy(publicPostLink)">
                                    {{ copied.value ? 'Copied!' : 'Copy link' }}
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </Stack>
                </Stack>
            </Stack>
        </Stack>

        <Stack class="gap-4 sm:gap-6 w-full">
            <p
                v-for="paragraph in paragraphs"
                class="sm:text-lg font-serif"
            >
                {{ paragraph }}
            </p>
        </Stack>

        <Separator class="my-8"/>

        <Stack
            justify="center"
            class="w-full gap-6 px-4"
        >
            <p class="text-center text-lg w-full">
                Thanks for reading {{ props.blog.name }}! <br/>
                Subscribe for free to receive new posts and support my work.
            </p>

            <SubscriptionInput
                :blog-slug="props.blog.slug"
                class="max-w-sm mx-auto"
            />
        </Stack>
    </BlogLayout>
</template>

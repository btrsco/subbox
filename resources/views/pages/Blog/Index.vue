<script setup lang="ts">
import { PostPagination } from '@/types'
import BlogLayout from '@/views/layouts/BlogLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import PostListItem from '@/views/pages/Blog/Partials/PostListItem.vue'
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { ArrowRightIcon, ImageIcon } from 'lucide-vue-next'
import { url } from '@/scripts/lib/url'
import { Avatar, AvatarFallback, AvatarImage } from '@/views/components/ui/avatar'
import { Separator } from '@/views/components/ui/separator'
import { route } from 'ziggy-js'
import { Input } from '@/views/components/ui/input'
import SubscriptionInput from '@/views/pages/Blog/Partials/SubscriptionInput.vue'
import { useDayjs } from '@/scripts/lib/dayjs'
import { getLocalTimeZone } from '@internationalized/date'

const props = defineProps<{
    emailVerified: boolean
    firstVisit: boolean
    blog: App.Models.Blog
    posts: PostPagination
    user: App.Models.User
    status?: string
}>()

const dayjs = useDayjs(getLocalTimeZone())
const firstPost = props.posts.data[0]
const otherPosts = props.posts.data.slice(1)

</script>

<template>
    <BlogLayout
        :email-verified="props.emailVerified"
        :first-visit="props.firstVisit"
        :title="props.blog.name"
        :blog="props.blog"
        :status="props.status"
    >
        <Stack
            direction="row"
            items="center"
            class="group grid sm:grid-cols-2 gap-4 py-4 sm:py-8"
        >
            <Stack
                :as="Link"
                :href="route('blog.posts.show', { blog: props.blog.slug, post: firstPost.slug })"
                class="aspect-[4/3] border bg-muted text-muted-foreground rounded-lg overflow-hidden flex-shrink-0"
            >
                <Stack
                    justify="center"
                    items="center"
                    class="w-full h-full"
                >
                    <ImageIcon class="size-5" />
                </Stack>
            </Stack>

            <Stack
                :as="Link"
                :href="route('blog.posts.show', { blog: props.blog.slug, post: firstPost.slug })"
                class="gap-1 sm:gap-3 sm:text-center"
            >
                <h2 class="text-2xl font-bold group-hover:text-accent-500 w-full">
                    {{ firstPost.title }}
                </h2>
                <p class="line-clamp-2">
                    {{ firstPost.content }}
                </p>
                <p class="w-full text-xs text-muted-foreground font-semibold tracking-wide uppercase">
                    {{ dayjs(firstPost.published_at).format('MMM D, YYYY') }} &middot; {{ props.user.name }}
                </p>
            </Stack>
        </Stack>

        <Separator />

        <Stack
            class="grid grid-cols-1 sm:grid-cols-5 gap-4"
        >
            <Stack class="order-2 sm:order-1 col-span-1 sm:col-span-3">
                <PostListItem
                    v-for="post in otherPosts"
                    :key="post.id"
                    :blog-slug="props.blog.slug"
                    :user-name="props.user.name"
                    :post="post"
                />

                <Button
                    :as="Link"
                    :href="route('blog.archive.index', { blog: props.blog.slug })"
                    variant="secondary"
                    class="mt-8"
                >
                    See all
                    <ArrowRightIcon class="ml-2 size-4"/>
                </Button>
            </Stack>
            <Stack class="order-1 sm:order-2 sm:sticky top-24 col-span-1 sm:col-span-2 py-4 sm:py-8 gap-4">
                <Stack class="gap-2">
                    <Avatar
                        shape="square"
                        class="size-8 cursor-pointer"
                    >
                        <AvatarImage
                            :src="url('/images/blog-placeholder.jpg')"
                            :alt="props.blog.name"
                        />
                        <AvatarFallback>{{ props.blog.initials }}</AvatarFallback>
                    </Avatar>

                    <h2 class="text-lg font-bold">
                        {{ props.blog.name }}
                    </h2>

                    <p class="text-muted-foreground text-xs">
                        {{ props.blog.bio }}
                    </p>
                </Stack>

                <Stack class="gap-2 w-full">
                    <SubscriptionInput
                        :blog-slug="props.blog.slug"
                        :status="props.status"
                    />
                </Stack>
            </Stack>
        </Stack>
    </BlogLayout>
</template>

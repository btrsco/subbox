<script setup lang="ts">
import { NavigationItem, PostPagination } from '@/types'
import { Stack } from '@/views/components/bespoke/stack'
import DashboardHeader from '@/views/layouts/Dashboard/Partials/DashboardHeader.vue'
import { usePage } from '@inertiajs/vue3'
import BlogLayout from '@/views/layouts/BlogLayout.vue'
import PostListItem from '@/views/pages/Blog/Partials/PostListItem.vue'
import MiniPagination from '@/views/pages/Dashboard/Partials/MiniPagination.vue'

const props = defineProps<{
    emailVerified: boolean
    firstVisit: boolean
    blog: App.Models.Blog
    posts: PostPagination
    user: App.Models.User
    status?: string
}>()
</script>

<template>
    <BlogLayout
        :email-verified="props.emailVerified"
        :first-visit="props.firstVisit"
        :title="props.blog.name"
        :blog="props.blog"
        :status="props.status"
        narrow
    >
        <Stack class="w-full">
            <PostListItem
                v-for="post in props.posts.data"
                :key="post.id"
                :blog-slug="props.blog.slug"
                :user-name="props.user.name"
                :post="post"
            />
        </Stack>

        <MiniPagination
            :pagination="props.posts"
            align="center"
        />
    </BlogLayout>
</template>

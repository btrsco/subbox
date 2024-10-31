<script setup lang="ts">
import { NavigationItem, PostPagination } from '@/types'
import { Stack } from '@/views/components/bespoke/stack'
import BlogLayout from '@/views/layouts/BlogLayout.vue'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import { route } from 'ziggy-js'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Card } from '@/views/components/ui/card'
import { url } from '@/scripts/lib/url'
import { Avatar, AvatarImage, AvatarFallback } from '@/views/components/ui/avatar'
import { Button } from '@/views/components/ui/button'

const props = defineProps<{
    emailVerified: boolean
    firstVisit: boolean
    blog: App.Models.Blog
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
        <Stack class="gap-3 w-full">
            <DashboardPageHeading heading="Stay up-to-date" />
            <p class="text-lg font-serif">
                Never miss an update—every new post is sent directly to your email inbox. For a spam-free,
                ad-free reading experience and community features.
            </p>
        </Stack>

        <Stack class="gap-3 w-full">
            <DashboardPageHeading heading="Join the crew" />
            <p class="text-lg font-serif">
                Be part of a community of people who share your interests. Participate in the comments
                section, or support this work with a subscription.
            </p>
            <p class="text-lg font-serif">
                To learn more about the tech platform that powers this publication, visit
                <Ahref route="home">{{ route('home') }}</Ahref>.
            </p>
        </Stack>

        <Stack class="gap-3 w-full grid grid-cols-1 sm:grid-cols-2">
            <DashboardPageHeading
                heading="People"
                class="col-span-1 sm:col-span-2"
            />
            <Card class="flex flex-col p-4 gap-4">
                <Stack
                    direction="row"
                    justify="between"
                    items="center"
                    class="w-full"
                >
                    <div class="text-lg font-bold">{{ props.user.name }}</div>
                    <Avatar
                        shape="circle"
                        class="size-12 cursor-pointer"
                    >
                        <AvatarImage
                            :src="url('/images/user-placeholder.jpg')"
                            :alt="props.user.name"
                        />
                        <AvatarFallback>{{ props.user.initials }}</AvatarFallback>
                    </Avatar>
                </Stack>

                <Button
                    variant="accent"
                    disabled
                    block
                >
                    Follow
                </Button>
            </Card>
        </Stack>
    </BlogLayout>
</template>

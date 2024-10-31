<script setup lang="ts">
import DashboardLayout from '@/views/layouts/DashboardLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { Link, usePage } from '@inertiajs/vue3'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/views/components/ui/card'
import SetUpListItem from '@/views/pages/Dashboard/Partials/SetUpListItem.vue'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import DashboardSectionTitle from '@/views/layouts/Dashboard/Partials/DashboardSectionTitle.vue'
import MetricCount from '@/views/pages/Dashboard/Partials/MetricCount.vue'
import { Alert, AlertDescription, AlertTitle } from '@/views/components/ui/alert'
import { PostPagination } from '@/types'
import PostList from '@/views/pages/Dashboard/Partials/PostList.vue'
import EmptyState from '@/views/pages/Dashboard/Partials/EmptyState.vue'

const $page = usePage()

const props = defineProps<{
    recentlyVerified: boolean
    setupCompleted: boolean
    subscriberCount: number
    draftPosts: PostPagination
    recentPosts: PostPagination
    postCount: number
}>()

const blog = $page.props.auth.blog
const hasFiveSubscribers = props.subscriberCount >= 5
const hasAtLeastOnePost = props.recentPosts.data.length > 0
const emailVerified = $page.props.auth.email_verified === true
</script>

<template>
    <DashboardLayout title="Dashboard">
        <template v-if="props.recentlyVerified" #alert>
            <Alert>
                <AlertTitle>
                    Your email address has been verified!
                </AlertTitle>
                <AlertDescription>
                    You can now access your blog and start sending emails to your subscribers.
                </AlertDescription>
            </Alert>
        </template>

        <DashboardPageHeading heading="Home">
            <template #actions>
                <Stack
                    direction="row"
                    class="gap-2"
                >
                    <Button
                        as="a"
                        :href="route('blog.index', { blog: blog?.slug })"
                        variant="outline"
                    >
                        View site
                    </Button>
                    <Button
                        :as="Link"
                        :href="route('dashboard.posts.create')"
                        variant="accent"
                    >
                        New post
                    </Button>
                </Stack>
            </template>
        </DashboardPageHeading>

        <Stack>
            <Card
                v-if="!setupCompleted"
                class="w-full"
            >
                <CardHeader>
                    <CardTitle>Welcome to your dashboard!</CardTitle>
                    <CardDescription>
                        Congratulations on creating your new {{ $page.props.app.name }}. Let's get you set up for
                        success.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Stack class="gap-2">
                        <SetUpListItem
                            :label="'Create a ' + $page.props.app.name"
                            :completed="true"
                        />
                        <SetUpListItem
                            label="Set up the basics"
                            :completed="true"
                        />
                        <SetUpListItem
                            label="Verify your email address"
                            :completed="emailVerified"
                            :href="route('dashboard.settings.account.edit')"
                        />
                        <SetUpListItem
                            label="Get your first 5 subscribers"
                            :completed="hasFiveSubscribers"
                        />
                        <SetUpListItem
                            label="Write your first post"
                            :completed="hasAtLeastOnePost"
                        />

                        <Button
                            as-child
                            variant="accent"
                            :disabled="!emailVerified || !hasFiveSubscribers || !hasAtLeastOnePost"
                            block
                        >
                            <Link
                                as="button"
                                :href="route('dashboard.hide-welcome')"
                                method="post"
                            >
                                Complete Setup
                            </Link>
                        </Button>
                    </Stack>
                </CardContent>
            </Card>
        </Stack>

        <Stack class="gap-3">
            <DashboardSectionTitle title="Overview" />

            <section class="grid grid-cols-1 md:grid-cols-2 w-full gap-4">
                <MetricCount
                    label="All subscribers"
                    :count="props.subscriberCount || 0"
                />
                <MetricCount
                    label="All posts"
                    :count="props.postCount || 0"
                />
            </section>
        </Stack>

        <Stack class="gap-4">
            <DashboardSectionTitle
                title="Drafts"
                action-label="View all"
                :action-href="route('dashboard.posts.index')"
            />

            <Card
                class="w-full px-4"
                :class="{ 'py-1': props.draftPosts.total > 0, 'py-4': props.draftPosts.total === 0 }"
            >
                <PostList
                    v-if="props.draftPosts.total > 0"
                    :posts="props.draftPosts"
                    no-image
                />
                <EmptyState
                    v-else
                    action-label="New post"
                    :action-href="route('dashboard.posts.create')"
                >
                    <p>
                        You don't have any draft posts yet!
                    </p>
                </EmptyState>
            </Card>
        </Stack>

        <Stack class="gap-4">
            <DashboardSectionTitle
                title="Recent posts"
                action-label="View all posts"
                :action-href="route('dashboard.posts.index')"
            />

            <Card
                class="w-full px-4"
                :class="{ 'py-1': props.recentPosts.total > 0, 'py-4': props.recentPosts.total === 0 }"
            >
                <PostList
                    v-if="props.recentPosts.total > 0"
                    :posts="props.recentPosts"
                />

                <EmptyState
                    v-else
                    action-label="New post"
                    :action-href="route('dashboard.posts.create')"
                >
                    <p>
                        You don't have any published posts yet!
                    </p>
                </EmptyState>
            </Card>
        </Stack>

    </DashboardLayout>
</template>

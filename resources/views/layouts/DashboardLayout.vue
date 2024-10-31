<script setup lang="ts">
import { usePage, Link } from '@inertiajs/vue3'
import { DashboardLayoutProps } from '@/types/layouts'
import PageHead from '@/views/components/utils/PageHead.vue'
import { NavigationItem, PageProps } from '@/types'
import { Stack } from '@/views/components/bespoke/stack'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import DashboardHeader from '@/views/layouts/Dashboard/Partials/DashboardHeader.vue'
import DashboardSecondaryNavigation from '@/views/layouts/Dashboard/Partials/DashboardSecondaryNavigation.vue'
import { Alert, AlertDescription, AlertTitle } from '@/views/components/ui/alert'
import { ArrowRightIcon } from 'lucide-vue-next'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Button } from '@/views/components/ui/button'

const props = defineProps<DashboardLayoutProps>()
const app = usePage().props.app as PageProps.App
const user = usePage().props.auth.user as App.Models.User
const blog = usePage().props.auth.blog as App.Models.Blog
const emailVerified = usePage().props.auth.email_verified
const pageTitle = props.title || blog.name || 'Dashboard'

const primaryNavigation: NavigationItem[] = [
    {
        label: 'Home',
        route: 'dashboard.index',
        type: 'link',
    },
    {
        label: 'Posts',
        route: 'dashboard.posts.index',
        type: 'link',
    },
    {
        label: 'Subscribers',
        route: 'dashboard.subscribers.index',
        type: 'link',
    },
    {
        label: 'Settings',
        route: 'dashboard.settings.account.edit',
        type: 'link',
    },
]
</script>

<template>
    <PageHead :title="pageTitle" />

    <Stack
        as="section"
        class="min-h-screen w-full"
    >

        <DashboardHeader
            :app="app"
            :user="user"
            :blog="blog"
            :navigation="primaryNavigation"
        />

        <Stack
            as="main"
            class="min-h-[calc(100vh_-_theme(spacing.16)_-_theme(spacing.10))] w-full flex-1 mx-auto gap-2"
            :class="{ 'max-w-4xl': !props.fullWidth }"
        >

            <Stack
                v-if="!emailVerified || $slots.alert"
                class="w-full pt-4 px-4 lg:px-10 mx-auto"
            >
                <Alert
                    v-if="!emailVerified"
                    variant="primary"
                >
                    <AlertTitle>
                        Verify your email address
                    </AlertTitle>
                    <AlertDescription>
                        Your blog will not be visible to the public until you verify your email address. <br>
                        <Ahref
                            :href="route('dashboard.settings.account.edit')"
                            class="text-accent mt-2 inline-block"
                        >
                            Go to settings
                        </Ahref>
                    </AlertDescription>
                </Alert>

                <slot
                    v-if="$slots.alert"
                    name="alert"
                />
            </Stack>

            <Stack class="w-full gap-4 lg:gap-8 pt-4 md:pt-8 pb-16 md:pb-24 px-4 lg:px-10 mx-auto">

                <DashboardPageHeading
                    :heading="props.heading"
                    :subheading="props.subheading"
                    :icon="props.icon"
                    :count="props.count"
                >
                    <template #details v-if="$slots.details">
                        <slot name="details" />
                    </template>
                </DashboardPageHeading>

                <Stack class="md:flex-row w-full gap-4 lg:gap-8">
                    <DashboardSecondaryNavigation
                        v-if="props.secondaryNavigation"
                        :navigation="props.secondaryNavigation"
                    />

                    <slot v-if="$slots.beforeContent" name="beforeContent" />

                    <div class="grid w-full gap-4 md:gap-8">
                        <slot />
                    </div>

                    <slot v-if="$slots.afterContent" name="afterContent" />
                </Stack>

            </Stack>

        </Stack>

    </Stack>

</template>

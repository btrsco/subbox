<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import DashboardHeader from '@/views/layouts/Dashboard/Partials/DashboardHeader.vue'
import { BlogLayoutProps } from '@/types/layouts'
import { Link, usePage } from '@inertiajs/vue3'
import { NavigationItem } from '@/types'
import PageHead from '@/views/components/utils/PageHead.vue'
import { Alert, AlertDescription, AlertTitle } from '@/views/components/ui/alert'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Button } from '@/views/components/ui/button'
import { BookmarkIcon, ChevronRightIcon, XIcon } from 'lucide-vue-next'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/views/components/ui/tooltip'
import SubscriptionOverlay from '@/views/pages/Blog/Partials/SubscriptionOverlay.vue'

const props = defineProps<BlogLayoutProps>()

const $page = usePage()
const app = $page.props.app
const user = $page.props.auth.user

const primaryNavigation: NavigationItem[] = [
    {
        label: 'Home',
        route: 'blog.index',
        params: { blog: props.blog.slug },
        type: 'link',
    },
    {
        label: 'Archive',
        route: 'blog.archive.index',
        params: { blog: props.blog.slug },
        type: 'link',
    },
    {
        label: 'About',
        route: 'blog.about.index',
        params: { blog: props.blog.slug },
        type: 'link',
    },
]
</script>

<template>
    <PageHead :title="props.title" />

    <Stack
        as="section"
        class="min-h-screen w-full"
    >

        <DashboardHeader
            :app="app"
            :navigation="primaryNavigation"
            :blog="props.blog"
            :user="user ?? undefined"
        />

        <Stack
            as="main"
            class="min-h-[calc(100vh_-_theme(spacing.16)_-_theme(spacing.10))] w-full flex-1 mx-auto gap-2"
            :class="{'max-w-4xl': !props.narrow, 'max-w-2xl': props.narrow }"
        >

            <Stack
                v-if="!props.emailVerified || $slots.alert"
                class="w-full pt-4 px-4 lg:px-10 mx-auto"
            >
                <Alert
                    v-if="!props.emailVerified && user!.id === props.blog.user_id"
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

                <Stack class="md:flex-row w-full gap-4 lg:gap-8">
                    <slot v-if="$slots.beforeContent" name="beforeContent" />

                    <div class="grid w-full gap-4 md:gap-8">
                        <slot />
                    </div>

                    <slot v-if="$slots.afterContent" name="afterContent" />
                </Stack>

            </Stack>

        </Stack>

        <Stack
            as="footer"
            items="center"
            class="w-full bg-muted border-t px-4 py-6 sm:px-8 sm:py-8 text-sm text-muted-foreground gap-4"
        >
            <TooltipProvider>
                <Tooltip :delay-duration="100">
                    <TooltipTrigger as-child>
                        <p>
                            &copy; {{ props.blog.name }} {{ new Date().getFullYear() }}
                            &middot;
                            <span class="underline-offset-4 underline cursor-pointer">Privacy</span>
                            &middot;
                            <span class="underline-offset-4 underline cursor-pointer">Terms</span>
                            &middot;
                            <span class="underline-offset-4 underline cursor-pointer">Disclaimers</span>
                        </p>
                    </TooltipTrigger>
                    <TooltipContent>
                        These links are placeholders
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>

            <Button
                :as="Link"
                :href="route('register')"
                variant="outline"
                class="group"
            >
                <BookmarkIcon class="text-accent dark:text-accent group-hover:text-accent-foreground size-5 mr-2"/>
                Start writing
            </Button>

            <p>
                <Ahref route="home">
                    {{ $page.props.app.name }}
                </Ahref>
                is a project by
                <a
                    class="underline-offset-4 hover:underline text-primary"
                    href="https://batres.co/?utm_source=subbox&utm_medium=footer"
                    target="_blank"
                >Miguel Batres</a>.
            </p>
        </Stack>
    </Stack>

    <SubscriptionOverlay
        :app-name="app.name"
        :blog-id="props.blog.id"
        :blog-slug="props.blog.slug"
        :blog-name="props.blog.name"
        :blog-initials="props.blog.initials ?? ''"
        :blog-bio="props.blog.bio"
        :first-visit="props.firstVisit"
        :status="props.status"
    />
</template>

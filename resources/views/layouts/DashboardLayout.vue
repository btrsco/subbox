<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { DashboardLayoutProps } from '@/types/layouts'
import PageHead from '@/views/components/utils/PageHead.vue'
import { NavigationItem, PageProps } from '@/types'
import { Stack } from '@/views/components/bespoke/stack'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import DashboardHeader from '@/views/layouts/Dashboard/Partials/DashboardHeader.vue'
import DashboardSecondaryNavigation from '@/views/layouts/Dashboard/Partials/DashboardSecondaryNavigation.vue'

const props = defineProps<DashboardLayoutProps>()
const app = usePage().props.app as PageProps.App
const user = usePage().props.auth.user as App.Models.User

const primaryNavigation: NavigationItem[] = [
    {
        label: 'Dashboard',
        route: 'dashboard',
        type: 'link',
    },
]
</script>

<template>

    <PageHead :title="title" />

    <Stack as="section" class="min-h-screen w-full bg-muted/40">

        <DashboardHeader
            :app="app"
            :user="user"
            :navigation="primaryNavigation"
        />

        <Stack
            as="main"
            class="min-h-[calc(100vh_-_theme(spacing.16))] w-full flex-1 gap-4 lg:gap-8 py-4 md:py-8 px-4 lg:px-10 mx-auto"
            :class="{ 'max-w-6xl': !props.fullWidth }"
        >

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

</template>

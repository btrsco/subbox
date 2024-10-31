<script setup lang="ts">
import { AuthLayoutProps } from '@/types/layouts'
import PageHead from '@/views/components/utils/PageHead.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { BookmarkIcon } from 'lucide-vue-next'
import { Button } from '@/views/components/ui/button'
import { Link, usePage } from '@inertiajs/vue3'
import { FormButton } from '@/views/components/ui/form'
import { NavigationItem } from '@/types'

const $page = usePage()
const props = defineProps<AuthLayoutProps>()

const guestNavigation: NavigationItem[] = [
    {
        label: 'Log in',
        route: 'login',
        type: 'link',
    },
    {
        label: 'Register',
        route: 'register',
        type: 'link',
    }
]

const authenticatedNavigation: NavigationItem[] = [
    {
        label: 'Dashboard',
        route: 'dashboard.index',
        type: 'link',
    },
    {
        label: 'Log out',
        route: 'logout',
        type: 'form',
    }
]

const navigation = $page.props.auth.user
    ? authenticatedNavigation
    : guestNavigation
</script>

<template>
    <PageHead :title="title" />

    <section class="flex flex-col md:flex-row w-full h-screen">

        <Stack
            v-if="!props.fullWidth"
            as="aside"
            direction="column"
            justify="between"
            class="w-full md:w-1/3 h-4 md:h-full bg-secondary text-secondary-foreground md:p-8">

            <Stack as="header" direction="row" items="center" class="hidden md:flex gap-2">
                <BookmarkIcon class="size-6 text-muted-foreground"></BookmarkIcon>
                <span class="text-lg font-semibold">{{ $page.props.app.name }}</span>
            </Stack>

            <Stack as="footer" direction="column" class="hidden md:flex gap-2 text-muted-foreground max-w-[40rem]">
                <p class="text-base xl:text-lg font-medium">
                    &ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquam architecto at dolore
                    ducimus est id incidunt labore maxime molestias necessitatibus numquam.&rdquo;
                </p>
                <p class="text-sm">Sofia Davis</p>
            </Stack>

        </Stack>

        <main class="w-full p-4 md:p-8 flex flex-col gap-24 md:gap-12" :class="!props.fullWidth ? 'md:w-2/3' : ''">

            <Stack as="header" direction="row" justify="between" items="center" class="w-full">
                <BookmarkIcon class="size-6" :class="!props.fullWidth ? 'md:hidden' : ''"></BookmarkIcon>

                <ul v-if="!props.hideNavigation" class="list-none text-sm flex flex-row ml-auto">
                    <li v-for="item in navigation" :key="item.route">
                        <Button
                            v-if="item.type === 'link'"
                            :as="Link"
                            :href="route(item.route)"
                            variant="ghost"
                            size="sm"
                            :class="route().current(item.route) ? 'text-primary' : 'text-muted-foreground'">
                            {{ item.label }}
                        </Button>

                        <FormButton
                            v-else-if="item.type === 'form'"
                            :route="item.route"
                            variant="ghost"
                            size="sm"
                            class="text-muted-foreground">
                            {{ item.label }}
                        </FormButton>
                    </li>
                </ul>

                <div v-else></div>
            </Stack>

            <div class="flex flex-1 justify-center items-center">
                <slot />
            </div>

            <footer>
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ new Date().getFullYear() }} {{ $page.props.app.name }}. All rights reserved.
                </p>
            </footer>

        </main>

    </section>
</template>

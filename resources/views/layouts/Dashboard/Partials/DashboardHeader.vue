<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { NavigationItem, PageProps } from '@/types'
import { SettingsIcon, GlobeIcon, LayoutGridIcon } from 'lucide-vue-next'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import ThemeToggle from '@/views/components/bespoke/theme-toggle/ThemeToggle.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { Avatar, AvatarFallback, AvatarImage } from '@/views/components/ui/avatar'
import { url } from '@/scripts/lib/url'
import { Button } from '@/views/components/ui/button'

const props = defineProps<{
    app: PageProps.App
    user?: App.Models.User
    blog: App.Models.Blog
    navigation: NavigationItem[]
}>()
</script>

<template>
    <Stack
        direction="row"
        justify="between"
        items="center"
        class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b w-full bg-background px-4 md:px-6"
    >

        <Stack
            direction="row"
            class="md:flex-1 md:w-full"
        >
            <Link
                :href="route('blog.index', { blog: props.blog.slug })"
                class="size-9"
            >
                <Avatar
                    shape="square"
                    class="size-9"
                >
                    <AvatarImage
                        :src="url('/images/blog-placeholder.jpg')"
                        :alt="props.blog.name"
                    />
                    <AvatarFallback>{{ props.blog.initials }}</AvatarFallback>
                </Avatar>
            </Link>
        </Stack>
        <Stack
            direction="row"
            justify="center"
            class="mr-auto md:mr-0 md:flex-1 md:w-full text-xl font-bold flex-nowrap text-nowrap"
        >
            <Link :href="route('blog.index', { blog: props.blog.slug })">
            {{ props.blog.name }}
            </Link>
        </Stack>
        <Stack
            direction="row"
            justify="end"
            items="center"
            class="flex-1 w-full gap-2"
        >
            <ThemeToggle />

            <DropdownMenu v-if="props.user">
                <DropdownMenuTrigger as-child>
                    <Avatar
                        shape="circle"
                        class="size-9 cursor-pointer"
                    >
                        <AvatarImage
                            :src="url('/images/user-placeholder.jpg')"
                            :alt="props.user.name"
                        />
                        <AvatarFallback>{{ props.user.initials }}</AvatarFallback>
                    </Avatar>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuLabel>
                        <Stack direction="row" items="center" class="gap-2">
                            <Avatar shape="circle">
                                <AvatarImage
                                    :src="url('/images/user-placeholder.jpg')"
                                    :alt="props.user.name"
                                />
                                <AvatarFallback>{{ props.user.initials }}</AvatarFallback>
                            </Avatar>
                            <Stack direction="column">
                                <span class="font-semibold">{{ props.user.name }}</span>
                                <span class="text-xs font-normal text-muted-foreground">{{ props.user.email }}</span>
                            </Stack>
                        </Stack>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem as-child>
                        <Link
                            :href="route('blog.index', {blog: props.blog.slug})"
                            class="cursor-pointer"
                        >
                            <GlobeIcon class="size-4 mr-2" />
                            View blog
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem as-child>
                        <Link
                            :href="route('dashboard.index')"
                            class="cursor-pointer"
                        >
                            <LayoutGridIcon class="size-4 mr-2" />
                            Dashboard
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem as-child>
                        <Link
                            :href="route('dashboard.settings.account.edit')"
                            class="cursor-pointer"
                        >
                            <SettingsIcon class="size-4 mr-2" />
                            Settings
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem as-child>
                        <Link
                            :href="route('logout')"
                            method="post"
                            class="text-muted-foreground cursor-pointer"
                        >
                            Log out
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <template
                v-else
            >
                <Button
                    :as="Link"
                    variant="secondary"
                    size="sm"
                    :href="route('login')"
                >
                    Log in
                </Button>

                <Button
                    :as="Link"
                    variant="accent"
                    size="sm"
                    :href="route('register')"
                >
                    Register
                </Button>
            </template>
        </Stack>

    </Stack>
    <Stack
        as="nav"
        direction="row"
        items="center"
        class="sticky top-16 z-30 flex h-10 items-center gap-4 border-b w-full bg-background md:px-6 md:justify-center"
    >
        <Stack
            as="ul"
            direction="row"
            class="list-none m-0 p-0"
        >
            <Link
                v-for="item in props.navigation.filter(item => item.type === 'link')"
                :key="item.route"
                :href="route(item.route, item.params ?? undefined)"
                class="h-10 px-4 group hover:bg-muted"
            >
                <li
                    class="text-sm block text-primary h-10 border-b-2 py-2.5"
                    :class="route().current(item.route) ? 'border-primary font-semibold' : 'border-transparent'"
                >
                    {{ item.label }}
                </li>
            </Link>
        </Stack>
    </Stack>
</template>

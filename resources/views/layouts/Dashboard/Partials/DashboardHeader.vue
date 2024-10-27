<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { CircleUserIcon, CommandIcon, MenuIcon, SearchIcon } from 'lucide-vue-next'
import { NavigationItem, PageProps } from '@/types'
import { Sheet, SheetContent, SheetTrigger } from '@/views/components/ui/sheet'
import { Input } from '@/views/components/ui/input'
import { Button } from '@/views/components/ui/button'
import { FormIconWrapper } from '@/views/components/ui/form'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import ThemeToggle from '@/views/components/bespoke/theme-toggle/ThemeToggle.vue'

const props = defineProps<{
    app: PageProps.App
    user: App.Models.User
    navigation: NavigationItem[]
}>()
</script>

<template>
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b w-full bg-background px-4 md:px-6">

        <!--Desktop Navigation-->
        <nav class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6">
            <a
                href="#"
                class="flex items-center gap-2 text-lg font-semibold md:text-base"
            >
                <CommandIcon class="h-6 w-6" />
                <span class="sr-only">{{ app.name }}</span>
            </a>
            <Link
                v-for="item in props.navigation"
                :key="item.label"
                :href="route(item.route)"
                class="transition-colors flex-shrink-0"
                :class="[route().current(item.route) ? 'font-medium text-foreground' : 'text-muted-foreground hover:text-foreground']">
                {{ item.label }}
                <span class="sr-only">(current)</span>
            </Link>
        </nav>

        <!--Mobile Navigation-->
        <Sheet>

            <SheetTrigger as-child>
                <Button
                    variant="outline"
                    size="icon"
                    class="shrink-0 md:hidden"
                >
                    <MenuIcon class="h-5 w-5" />
                    <span class="sr-only">Toggle navigation menu</span>
                </Button>
            </SheetTrigger>
            <SheetContent side="left">
                <nav class="grid gap-6 text-lg font-medium">
                    <a
                        href="#"
                        class="flex items-center gap-2 text-lg font-semibold">
                        <CommandIcon class="h-6 w-6" />
                        <span class="sr-only">{{ app.name }}</span>
                    </a>
                    <Link
                        v-for="item in props.navigation"
                        :key="item.label"
                        :href="route(item.route)"
                        class="transition-colors"
                        :class="[route().current(item.route) ? 'font-medium text-foreground' : 'text-muted-foreground hover:text-foreground']">
                        {{ item.label }}
                        <span class="sr-only">(current)</span>
                    </Link>
                </nav>
            </SheetContent>

        </Sheet>

        <!--Right Side-->
        <div class="flex w-full items-center gap-4 md:ml-auto md:gap-2 lg:gap-4">

            <form class="ml-auto flex-1 sm:flex-initial">
                <div class="relative">
                    <Input
                        type="search"
                        placeholder="Search..."
                        class="pl-8 sm:w-[300px] md:w-[200px] lg:w-[300px]"
                    />
                    <FormIconWrapper>
                        <SearchIcon class="size-4 text-muted-foreground" />
                    </FormIconWrapper>
                </div>
            </form>

            <ThemeToggle size="icon" />

            <DropdownMenu>

                <DropdownMenuTrigger as-child>
                    <Button variant="secondary" size="icon" class="rounded-full">
                        <CircleUserIcon class="h-5 w-5" />
                        <span class="sr-only">Toggle user menu</span>
                    </Button>
                </DropdownMenuTrigger>

                <DropdownMenuContent align="end">
                    <DropdownMenuLabel>
                        {{ user?.name ?? 'My Account' }}
                    </DropdownMenuLabel>

                    <DropdownMenuSeparator />

                    <DropdownMenuItem :as="Link" :href="route('settings.account.edit')" class="cursor-pointer">
                        Settings
                    </DropdownMenuItem>

                    <DropdownMenuSeparator />

                    <form @click="(useForm({})).post(route('logout'))">
                        <DropdownMenuItem class="text-destructive focus:bg-destructive focus:text-destructive-foreground cursor-pointer">
                            Log out
                        </DropdownMenuItem>
                    </form>
                </DropdownMenuContent>

            </DropdownMenu>

        </div>
    </header>
</template>

<style scoped>

</style>

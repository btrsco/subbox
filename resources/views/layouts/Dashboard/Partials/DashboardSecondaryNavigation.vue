<script setup lang="ts">
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { Stack } from '@/views/components/bespoke/stack'
import { NavigationItem } from '@/types'
import { ChevronsUpDownIcon } from 'lucide-vue-next'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem, DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import { Separator } from '@/views/components/ui/separator'

const props = defineProps<{
    navigation: Array<NavigationItem>
}>()

const currentRoute = props.navigation.filter( item => {
    return item.type === 'link'
}).find(item => {
    return route().current(item.route, item.params)
}) || null
</script>

<template>

    <Stack as="aside" class="hidden md:flex w-full max-w-56">

        <template v-for="item in props.navigation">
            <Button
                v-if="item.type !== 'separator'"
                variant="link"
                size="sm"
                class="justify-start gap-2 px-0"
                :class="[route().current(item.route, item.params) ? 'text-primary' : 'text-muted-foreground']"
                as-child
                block
            >
                <Link :href="route(item.route, item.params)">
                    <component
                        v-if="item.icon"
                        :is="item.icon"
                        class="size-4"
                    />
                    {{ item.label }}
                </Link>
            </Button>
            <Separator v-else class="my-2" />
        </template>

    </Stack>

    <Stack as="aside" class="md:hidden w-full">

        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button
                    v-if="currentRoute"
                    variant="outline"
                    size="lg"
                    class="justify-between gap-2 px-2"
                    block
                >
                    <Stack direction="row" align="center" class="gap-2">
                        <component
                            v-if="currentRoute.icon"
                            :is="currentRoute.icon"
                            class="size-5"
                        />
                        <span class="text-base">{{ currentRoute.label }}</span>
                    </Stack>

                    <ChevronsUpDownIcon class="text-muted-foreground size-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent side="bottom" align="start">
                <template v-for="item in props.navigation">
                    <DropdownMenuItem
                        v-if="item.type !== 'separator'"
                        as-child
                    >
                        <Link
                            :href="route(item.route, item.params)"
                            class="flex justify-start items-center gap-2"
                            :class="[ route().current(item.route, item.params) ? 'text-primary' : 'text-muted-foreground' ]"
                        >
                            <component
                                v-if="item.icon"
                                :is="item.icon"
                                class="size-4"
                            />
                            {{ item.label }}
                        </Link>
                    </DropdownMenuItem>

                    <DropdownMenuSeparator v-else />
                </template>
            </DropdownMenuContent>
        </DropdownMenu>

    </Stack>

</template>

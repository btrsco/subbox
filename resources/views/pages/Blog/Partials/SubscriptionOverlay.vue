<script setup lang="ts">
import { url } from '@/scripts/lib/url'
import { ChevronRightIcon, XIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { Avatar, AvatarFallback, AvatarImage } from '@/views/components/ui/avatar'
import { Button } from '@/views/components/ui/button'
import SubscriptionInput from '@/views/pages/Blog/Partials/SubscriptionInput.vue'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/views/components/ui/tooltip'
import { ref } from 'vue'

const props = defineProps<{
    appName: string
    blogId: number
    blogSlug: string
    blogBio: string
    blogInitials: string
    blogName: string
    firstVisit: boolean
    status?: string
}>()

const isOpen = ref(props.firstVisit)

const closeOverlay = () => {
    isOpen.value = false
    console.log('close overlay')
}
</script>

<template>
    <Stack
        justify="between"
        items="center"
        class="fixed z-40 inset-0 bg-background"
        v-show="isOpen"
    >
        <Stack
            as="header"
            direction="row"
            justify="end"
            items="center"
            class="w-full p-4"
        >
            <Button
                variant="ghost"
                size="icon-sm"
                @click="closeOverlay"
            >
                <XIcon class="size-5"/>
            </Button>
        </Stack>

        <Stack
            items="center"
            class="gap-8 w-full max-w-sm p-4"
        >
            <Avatar
                shape="square"
                class="size-20 cursor-pointer"
            >
                <AvatarImage
                    :src="url('/images/blog-placeholder.jpg')"
                    :alt="props.blogName"
                />
                <AvatarFallback>{{ props.blogInitials }}</AvatarFallback>
            </Avatar>

            <Stack class="gap-4">
                <h1 class="text-2xl font-bold text-center w-full">
                    {{ props.blogName }}
                </h1>
                <p class="text-center">
                    {{ props.blogBio }}
                </p>
            </Stack>

            <SubscriptionInput
                :blog-slug="props.blogSlug"
                :status="props.status"
                @subscribed="closeOverlay"
            />

            <Stack
                direction="row"
                items="center"
                class="text-sm font-semibold text-muted-foreground cursor-pointer"
                @click="closeOverlay"
            >
                No thanks
                <ChevronRightIcon class="size-4 ml-2"/>
            </Stack>
        </Stack>

        <Stack
            as="footer"
            direction="row"
            justify="center"
            items="center"
            class="w-full p-4 text-xs text-muted-foreground/50 dark:text-muted"
        >
            <TooltipProvider>
                <Tooltip :delay-duration="100">
                    <TooltipTrigger as-child>
                        <p>
                            By registering you agree to {{ props.appName }}'s
                            <span class="underline-offset-4 underline cursor-pointer">Terms of Service</span>,
                            our
                            <span class="underline-offset-4 underline cursor-pointer">Privacy Policy</span>,
                            and our
                            <span class="underline-offset-4 underline cursor-pointer">Disclaimers Notice</span>.
                        </p>
                    </TooltipTrigger>
                    <TooltipContent>
                        These links are placeholders
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>
        </Stack>
    </Stack>
</template>

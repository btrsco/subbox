<script setup lang="ts">
import PageHead from '@/views/components/utils/PageHead.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { ChevronLeftIcon, DotIcon } from 'lucide-vue-next'
import { Button } from '@/views/components/ui/button'
import { router, useForm as inertiaForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { Badge } from '@/views/components/ui/badge'
import { getLocalTimeZone } from '@internationalized/date'
import { useDayjs } from '@/scripts/lib/dayjs'
import PostScheduleDialog from '@/views/pages/Dashboard/Partials/PostScheduleDialog.vue'
import ThemeToggle from '@/views/components/bespoke/theme-toggle/ThemeToggle.vue'
import ContentEditable from '@/views/pages/Dashboard/Partials/ContentEditable.vue'
import { Separator } from '@/views/components/ui/separator'

const props = defineProps<{
    post: App.Models.Post
}>()

const saving = ref(false)
const saved = computed(() => ! saving.value && !form.isDirty)
const dayjs = useDayjs(getLocalTimeZone())
const scheduledDate = ref<string>()
const scheduledTimeHour = ref<string>()
const scheduledTimeMinute = ref<string>()

const form = inertiaForm({
    title: props.post.title === 'Untitled' ? '' : props.post.title,
    subtitle: props.post.subtitle ?? '',
    content: props.post.content ?? '',
    published_at: props.post.published_at ?? '',
})

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back()
    } else {
        router.visit(route('dashboard.posts.index'))
    }
}

const savePost = () => {
    saving.value = true
    form.published_at = props.post.published_at ?? ''

    onSubmit()
}

const publishPost = () => {
    saving.value = true
    form.published_at = 'now'

    onSubmit(true)
}

const schedulePost = (shouldSchedule: boolean) => {
    console.log('shouldSchedule', shouldSchedule)

    if ( ! shouldSchedule) return

    saving.value = true

    form.published_at = dayjs(scheduledDate.value)
        .hour(Number(scheduledTimeHour.value))
        .minute(Number(scheduledTimeMinute.value))
        .toISOString()

    onSubmit(true)
}

const onSubmit = (back: boolean = false) => {
    form.patch(route('dashboard.posts.update', { post: props.post.id }), {
        preserveScroll: true,
        onSuccess: () => {
            saving.value = false

            if (back) goBack()
        },
        onError: () => {
            saving.value = false
        },
    })
}

const indicatorLabel = computed(() => {
    if (saving.value) {
        return 'Saving...'
    }

    if (saved.value && !saving.value) {
        return 'Saved'
    }

    return 'Pending changes'
})
</script>

<template>
    <PageHead :title="'Testing'" />

    <Stack class="bg-muted/50 w-full h-screen absolute inset-0">
        <Stack
            direction="row"
            justify="between"
            items="center"
            class="w-full p-4"
        >
            <Stack
                as="header"
                direction="row"
                items="center"
                class="gap-4"
            >
                <Button
                    variant="outline"
                    size="icon-sm"
                    @click="goBack"
                >
                    <ChevronLeftIcon class="size-4 text-muted-foreground"></ChevronLeftIcon>
                </Button>

                <Stack
                    direction="row"
                    items="center"
                >
                    <DotIcon
                        class="size-6 transition-all"
                        :class="{ 'text-amber-500 dark:text-amber-600 animate-pulse': saving, 'text-green-500 dark:text-green-600': saved && !saving, 'text-destructive': !saved && !saving }"
                    />
                    <div class="text-sm text-muted-foreground">
                        {{ indicatorLabel }}
                    </div>
                    <Badge
                        v-if="props.post.status"
                        variant="gray"
                        class="ml-4"
                    >
                        {{ props.post.status.substr(0, 1).toUpperCase() + props.post.status.substr(1) }}
                    </Badge>
                </Stack>
            </Stack>

            <Stack
                direction="row"
                justify="end"
                items="center"
                class="gap-2"
            >
                <ThemeToggle />
                <PostScheduleDialog
                    @update:date="value => scheduledDate = value"
                    @update:hour="value => scheduledTimeHour = value"
                    @update:minute="value => scheduledTimeMinute = value"
                    @schedule="schedulePost"
                >
                    <Button
                        variant="outline"
                        size="sm"
                    >
                        Schedule
                    </Button>
                </PostScheduleDialog>

                <Button
                    variant="accent"
                    size="sm"
                    @click="publishPost"
                >
                    Publish
                </Button>
            </Stack>
        </Stack>

        <Stack
            as="main"
            items="center"
            class="w-full h-full p-4 gap-4 overflow-y-scroll"
        >
            <Stack
                class="w-full max-w-3xl gap-2 sm:gap-4"
            >
                <ContentEditable
                    v-model="form.title"
                    class="text-2xl sm:text-4xl font-bold leading-12 min-h-12"
                    placeholder="Title"
                />

                <ContentEditable
                    v-model="form.subtitle"
                    class="sm:text-lg"
                    placeholder="Add a subtitle..."
                />

                <Separator />

                <textarea
                    class="sm:text-lg font-serif min-h-screen w-full bg-transparent border-none p-0 focus:outline-none focus:ring-0"
                    placeholder="Start writing..."
                    v-model="form.content"
                />

            </Stack>
        </Stack>

        <Stack
            direction="row"
            justify="end"
            items="center"
            class="w-full p-4 fixed left-0 right-0 bottom-0 pointer-events-none"
        >
            <Button
                size="sm"
                class="pointer-events-auto"
                :disabled="saved && !saving"
                @click="savePost"
            >
                Save
            </Button>
        </Stack>
    </Stack>
</template>

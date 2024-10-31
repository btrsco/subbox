<script setup lang="ts">
import { CopyIcon, EllipsisIcon, PenIcon, TrashIcon, Undo2Icon } from 'lucide-vue-next'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import { Button } from '@/views/components/ui/button'
import { Link, useForm as inertiaForm, usePage } from '@inertiajs/vue3'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle
} from '@/views/components/ui/dialog'
import { FormControl, FormField, FormItem, FormMessage } from '@/views/components/ui/form'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { ref } from 'vue'
import { useClipboard } from '@vueuse/core'

const props = defineProps<{
    post: App.Models.Post
}>()

const $page = usePage()
const confirmationInput = ref<HTMLInputElement | null>(null)
const isDialogOpen = ref(false)

const formSchema = toTypedSchema(z.object({
    confirmation: z.string()
    .trim()
    .toLowerCase()
    .refine((val) => val === 'delete', { message: 'You must type \'delete\' to confirm.' }),
}))

const { handleSubmit, resetForm } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    confirmation: '',
})

const onSubmit = handleSubmit((values) => {
    form.delete(route('dashboard.posts.destroy', { post: props.post.id }), {
        preserveScroll: true,
        onError: () => confirmationInput.value?.focus(),
        onFinish: () => {
            form.reset()
            resetForm()
            closeDialog()
        },
    })
})

const openDialog = () => {
    isDialogOpen.value = true
    setTimeout(() => {
        confirmationInput.value?.focus()
    }, 100)
}

const closeDialog = () => {
    isDialogOpen.value = false
    resetForm()
}

const updateDialog = (value: boolean) => {
    isDialogOpen.value = value
}

const publicPostLink = ref(route('blog.posts.show', {
    blog: $page.props.auth.blog?.slug,
    post: props.post.slug
}))

const {copy, copied, isSupported} = useClipboard({source: publicPostLink.value})
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                size="icon-sm"
                class="text-muted-foreground"
            >
                <EllipsisIcon class="size-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem as-child>
                <Link
                    :href="route('dashboard.posts.edit', { post: props.post.id })"
                >
                    <PenIcon class="size-4 mr-2" />
                    Edit post
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem
                v-if="isSupported && props.post.status === 'published'"
                @click="copy(publicPostLink)"
            >
                <CopyIcon class="size-4 mr-2" />
                {{ copied ? 'Copied!' : 'Copy link' }}
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem
                v-if="props.post.status === 'published' || props.post.status === 'scheduled'"
                class="text-destructive focus:text-destructive-foreground focus:bg-destructive"
                as-child
            >
                <Link
                    :href="route('dashboard.posts.unpublish', { post: props.post.id })"
                    method="patch"
                >
                    <Undo2Icon class="size-4 mr-2" />
                    {{ props.post.status === 'published' ? 'Unpublish' : 'Unschedule' }}
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem
                class="text-destructive focus:text-destructive-foreground focus:bg-destructive"
                @click="openDialog"
            >
                <TrashIcon class="size-4 mr-2" />
                Delete
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <Dialog :open="isDialogOpen" @update:open="updateDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    Are you sure you want to delete this post?
                </DialogTitle>
                <DialogDescription>
                    To confirm you would like to permanently delete this post, type the word "delete" below.
                </DialogDescription>
            </DialogHeader>

            <FormField
                v-slot="{ componentField }"
                v-model="form.confirmation"
                name="confirmation"
                :validate-on-blur="false"
            >
                <FormItem>

                    <FormControl as="div" class="relative">
                        <Input
                            v-bind="componentField"
                            ref="confirmationInput"
                            type="text"
                            placeholder="Delete"
                        />
                    </FormControl>

                    <FormMessage name="confirmation" />

                </FormItem>
            </FormField>

            <DialogFooter>
                <DialogClose as-child>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeDialog"
                    >
                        Close
                    </Button>
                </DialogClose>

                <Button
                    type="submit"
                    variant="destructive"
                    @click="onSubmit"
                >
                    Delete post
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

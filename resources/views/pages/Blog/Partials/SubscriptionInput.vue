<script setup lang="ts">
import { Stack } from '@/views/components/bespoke/stack'
import { Input } from '@/views/components/ui/input'
import { Button } from '@/views/components/ui/button'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'

const props = defineProps<{
    blogSlug: string
    status?: string
}>()

const emits = defineEmits<{
    (e: 'subscribed', payload: string): void
}>()

const formSchema = toTypedSchema(z.object({
    email: z.string().email(),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    email: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('blog.subscription.store', { blog: props.blogSlug}), {
        onSuccess: () => {
            form.email = ''
            console.log('props.status', props.status)

            if (props.status === 'subscribed') {
                alert('Confirmation required: we sent an email to your inbox. Click the link there to finish subscribing.')
                emits('subscribed', 'subscribed')
            } else if (props.status === 'already_subscribed') {
                alert('You are already subscribed. Check your inbox for the latest posts.')
                emits('subscribed', 'already_subscribed')
            } else {
                alert('Something went wrong. Please try again.')
                emits('subscribed', 'error')
            }
        }
    })
})
</script>

<template>
    <Stack
        as="form"
        direction="row"
        class="w-full"
        @submit.prevent="onSubmit"
    >

        <FormField
            v-slot="{ componentField }"
            v-model="form.email"
            name="email"
            :validate-on-blur="false">
            <FormItem class="w-full">

                <FormControl
                    as="div"
                    class="flex flex-row w-full"
                >
                    <Input
                        v-bind="componentField"
                        type="email"
                        placeholder="Type your email..."
                        autocomplete="username"
                        class="rounded-r-none"
                    />

                    <Button
                        variant="accent"
                        class="rounded-l-none"
                    >
                        Subscribe
                    </Button>
                </FormControl>

                <FormMessage name="email" />

            </FormItem>
        </FormField>
    </Stack>
</template>

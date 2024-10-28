<script setup lang="ts">
import { useForm as inertiaForm } from '@inertiajs/vue3'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { ArrowRightIcon, MailCheckIcon, MailIcon } from 'lucide-vue-next'
import { Input } from '@/views/components/ui/input'
import { Button } from '@/views/components/ui/button'

const props = defineProps<{
    status?: string;
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
    form.post(route('password.email'))
})
</script>

<template>
    <AuthLayout title="Forgot Password">

        <section class="w-full max-w-80 space-y-6">

            <Stack align="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Forgot password</h1>
                <p class="text-muted-foreground">Provide your email below to get a password reset link sent to you.</p>
            </Stack>

            <form v-if="!props.status" class="space-y-4" @submit.prevent="onSubmit">

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.email"
                    name="email"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <FormLabel>Email</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="email"
                                placeholder="Email address"
                                autocomplete="username"
                                class="pl-8"
                                autofocus />

                            <FormIconWrapper>
                                <MailIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="email" />

                    </FormItem>
                </FormField>

                <Button
                    type="submit"
                    variant="accent"
                    :disabled="form.processing"
                    block
                >
                    Email reset link
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

            </form>

            <Stack
                v-else
                direction="row"
                justify="center"
                align="center"
                class="text-sm gap-2 text-green-700 dark:text-green-500">
                <MailCheckIcon class="size-4" />
                {{ props.status }}
            </Stack>

        </section>

    </AuthLayout>
</template>

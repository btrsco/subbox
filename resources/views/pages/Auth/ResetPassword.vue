<script setup lang="ts">
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Button } from '@/views/components/ui/button'
import { ArrowRightIcon, LockKeyholeIcon, MailIcon } from 'lucide-vue-next'
import { Input } from '@/views/components/ui/input'

const props = defineProps<{
    email: string;
    token: string;
}>()

const formSchema = toTypedSchema(z.object({
    email: z.string().email(),
    password: z.string().min(8),
    password_confirmation: z.string().min(8),
}).refine((data) => data.password === data.password_confirmation, {
    message: 'Passwords don\'t match',
    path: ['password_confirmation'],
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation')
        },
    })
})
</script>

<template>
    <AuthLayout title="Reset Password">

        <section class="w-full max-w-80 space-y-6">

            <Stack items="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Reset password</h1>
                <p class="text-muted-foreground">Enter your new password below.</p>
            </Stack>

            <form class="space-y-4" @submit.prevent="onSubmit">

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

                <FormField
                    v-slot="{ componentField }"
                    name="password"
                    v-model="form.password"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <FormLabel>Password</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Password"
                                class="pl-8" />

                            <FormIconWrapper>
                                <LockKeyholeIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="password" />

                    </FormItem>
                </FormField>

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.password_confirmation"
                    name="password_confirmation"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <FormLabel>Password, again</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Password, again"
                                class="pl-8" />

                            <FormIconWrapper>
                                <LockKeyholeIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="password_confirmation" />

                    </FormItem>
                </FormField>

                <Button
                    type="submit"
                    variant="accent"
                    :disabled="form.processing"
                    block
                >
                    Reset password
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

            </form>

        </section>

    </AuthLayout>
</template>

<script setup lang="ts">
import * as z from 'zod'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Button } from '@/views/components/ui/button'
import { Input } from '@/views/components/ui/input'
import { ArrowRightIcon, CircleUserIcon, LockKeyholeIcon, MailIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { useForm as veeForm } from 'vee-validate'
// import { TextSeparator } from '@/views/components/bespoke/text-separator';

const props = defineProps<{
    status?: string;
}>()

const formSchema = toTypedSchema(z.object({
    name: z.string().min(3),
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
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation')
        },
    })
})
</script>

<template>
    <AuthLayout title="Register An Account">
        <section class="w-full max-w-80 space-y-6">

            <Stack items="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Join the community</h1>
                <p class="text-muted-foreground">Register to access your dashboard, settings and content.</p>
            </Stack>

            <form class="space-y-4" @submit.prevent="onSubmit">

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.name"
                    name="name"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <FormLabel>Full name</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="text"
                                placeholder="Full name"
                                class="pl-8"
                                autofocus />

                            <FormIconWrapper>
                                <CircleUserIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="name" />

                    </FormItem>
                </FormField>

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
                                class="pl-8" />

                            <FormIconWrapper>
                                <MailIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="email" />

                    </FormItem>
                </FormField>

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.password"
                    name="password"
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
                    Register
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

            </form>

            <Stack
                as="footer"
                items="center"
                class="gap-2 text-sm text-center text-muted-foreground"
            >
                <section>
                    Have an account?
                    <Ahref route="login">Log in.</Ahref>
                </section>
            </Stack>

        </section>

    </AuthLayout>
</template>

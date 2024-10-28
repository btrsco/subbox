<script setup lang="ts">
import * as z from 'zod'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Ahref } from '@/views/components/bespoke/ahref'
import { Button } from '@/views/components/ui/button'
import { Checkbox } from '@/views/components/ui/checkbox'
import { Input } from '@/views/components/ui/input'
import { Label } from '@/views/components/ui/label'
import { ArrowRightIcon, LockKeyholeIcon, MailIcon } from 'lucide-vue-next'
import { Stack } from '@/views/components/bespoke/stack'
import { toTypedSchema } from '@vee-validate/zod'
import { router, useForm as inertiaForm } from '@inertiajs/vue3'
import { useForm as veeForm } from 'vee-validate'
// import { TextSeparator } from '@/views/components/bespoke/text-separator';

const props = defineProps<{
    canResetPassword?: boolean;
    canRegister?: boolean;
    status?: string;
}>()

const formSchema = toTypedSchema(z.object({
    email: z.string().email(),
    password: z.string().min(8),
    remember: z.boolean().optional(),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    email: '',
    password: '',
    remember: false,
})

const onSubmit = handleSubmit((values) => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password')
        },
    })
})

const updateRemember = (value: boolean) => {
    form.remember = value
}

const onPasskeySuccess = () => {
    router.visit(route('dashboard'))
}
</script>

<template>
    <AuthLayout title="Log In">

        <section class="w-full max-w-80 space-y-6">

            <Stack align="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Welcome back</h1>
                <p class="text-muted-foreground">Log in to access your dashboard, settings and content.</p>
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
                    v-model="form.password"
                    name="password"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <Stack direction="row" justify="between">
                            <FormLabel>Password</FormLabel>
                            <Ahref v-if="props.canResetPassword" route="password.request" size="sm">Forgot password?</Ahref>
                        </Stack>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="password"
                                autocomplete="current-password"
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
                    name="remember"
                    type="checkbox"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <Stack direction="row" align="center" class="space-x-1">
                            <Checkbox
                                id="remember"
                                v-bind="componentField"
                                :checked="form.remember"
                                @update:checked="updateRemember" />
                            <Label for="remember">Remember me</Label>
                        </Stack>

                    </FormItem>
                </FormField>

                <Button
                    type="submit"
                    variant="accent"
                    :disabled="form.processing"
                    block
                >
                    Log in
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

            </form>

            <Stack
                v-if="props.canRegister"
                as="footer"
                align="center"
                class="gap-2 text-sm text-center text-muted-foreground"
            >
                <section>
                    No account?
                    <Ahref route="register">Register an account.</Ahref>
                </section>
            </Stack>

        </section>

    </AuthLayout>
</template>

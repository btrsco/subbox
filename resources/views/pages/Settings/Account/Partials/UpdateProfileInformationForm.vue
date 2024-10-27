<script setup lang="ts">
import { router, useForm as inertiaForm, usePage } from '@inertiajs/vue3'
import { CircleUserIcon, MailIcon } from 'lucide-vue-next'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Button } from '@/views/components/ui/button'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { Ahref } from '@/views/components/bespoke/ahref'

const props = defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>()

const user = usePage().props.auth.user as App.Models.User

const formSchema = toTypedSchema(z.object({
    name: z.string().min(3),
    email: z.string().email(),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    name: user?.name ?? '',
    email: user?.email ?? '',
})

const onSubmit = handleSubmit((values) => {
    form.patch(route('settings.account.update'), {
        preserveState: true,
        onSuccess: () => {
            router.reload({
                only: ['mustVerifyEmail']
            })
        },
    })
})
</script>

<template>
    <form @submit.prevent="onSubmit">

        <Card>

            <CardHeader>

                <CardTitle>Personal information</CardTitle>
                <CardDescription>
                    Update your account's profile information and email address.
                </CardDescription>

            </CardHeader>

            <CardContent class="grid grid-cols-1 gap-4 lg:grid-cols-6">

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.name"
                    name="name"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1 sm:col-span-4">

                        <FormLabel>Name</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="text"
                                placeholder="Full name"
                                class="pl-8"
                                autocomplete="name" />

                            <FormIconWrapper>
                                <CircleUserIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="email" />

                    </FormItem>
                </FormField>

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.email"
                    name="email"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1 sm:col-span-4">

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

                        <div v-if="mustVerifyEmail && user?.email_verified_at === null">
                            <p class="text-sm mt-2 text-muted-foreground">
                                Your email address is unverified.
                                <Ahref
                                    :href="route('verification.send')"
                                    method="post">
                                    Click here to re-send the verification email.
                                </Ahref>
                            </p>

                            <div
                                v-show="status === 'verification-link-sent'"
                                class="mt-2 font-medium text-sm text-green-700 dark:text-green-500">
                                A new verification link has been sent to your email address.
                            </div>
                        </div>

                    </FormItem>
                </FormField>

            </CardContent>

            <CardFooter class="border-t py-4 space-x-4">
                <Button
                    type="submit"
                    variant="default"
                    :disabled="form.processing || !form.isDirty">
                    Save changes
                </Button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </CardFooter>

        </Card>

    </form>
</template>

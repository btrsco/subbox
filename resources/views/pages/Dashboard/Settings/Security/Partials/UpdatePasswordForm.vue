<script setup lang="ts">
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { LockKeyholeIcon, LockKeyholeOpenIcon } from 'lucide-vue-next'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Button } from '@/views/components/ui/button'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'

const passwordInput = ref<HTMLInputElement | null>(null)
const currentPasswordInput = ref<HTMLInputElement | null>(null)

const formSchema = toTypedSchema(z.object({
    current_password: z.string().min(8),
    password: z.string().min(8),
    password_confirmation: z.string().min(8),
}).refine((data) => data.password === data.password_confirmation, {
    message: 'Passwords don\'t match',
    path: ['password_confirmation'],
}))

const { handleSubmit, resetForm } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const onSubmit = handleSubmit((values) => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            resetForm()
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation')
                passwordInput.value?.focus()
            }
            if (form.errors.current_password) {
                form.reset('current_password')
                currentPasswordInput.value?.focus()
            }
        },
    })
})
</script>

<template>
    <form @submit.prevent="onSubmit">

        <Card>

            <CardHeader>

                <CardTitle>Update password</CardTitle>
                <CardDescription>
                    Ensure your account is using a long, random password to stay secure.
                </CardDescription>

            </CardHeader>

            <CardContent class="grid grid-cols-1 gap-4">

                <FormField
                    v-slot="{ componentField }"
                    v-model="form.current_password"
                    name="current_password"
                    :validate-on-blur="false">
                    <FormItem class="space-y-1">

                        <FormLabel>Current password</FormLabel>

                        <FormControl as="div" class="relative">
                            <Input
                                v-bind="componentField"
                                type="password"
                                placeholder="Current password"
                                autocomplete="current-password"
                                class="pl-8" />

                            <FormIconWrapper>
                                <LockKeyholeOpenIcon class="size-4 text-muted-foreground" />
                            </FormIconWrapper>
                        </FormControl>

                        <FormMessage name="current_password" />

                    </FormItem>
                </FormField>

                <div class="grid gap-4 sm:grid-cols-2">
                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.password"
                        name="password"
                        class="col-span-2 sm:col-span-1"
                        :validate-on-blur="false">
                        <FormItem class="space-y-1">

                            <FormLabel>New password</FormLabel>

                            <FormControl as="div" class="relative">
                                <Input
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="New password"
                                    autocomplete="new-password"
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
                        class="col-span-2 sm:col-span-1"
                        :validate-on-blur="false">
                        <FormItem class="space-y-1">

                            <FormLabel>Confirm password</FormLabel>

                            <FormControl as="div" class="relative">
                                <Input
                                    v-bind="componentField"
                                    type="password"
                                    placeholder="Confirm password"
                                    autocomplete="new-password"
                                    class="pl-8" />

                                <FormIconWrapper>
                                    <LockKeyholeIcon class="size-4 text-muted-foreground" />
                                </FormIconWrapper>
                            </FormControl>

                            <FormMessage name="password_confirmation" />

                        </FormItem>
                    </FormField>
                </div>

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

<script setup lang="ts">
import { useForm as inertiaForm } from '@inertiajs/vue3'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { ArrowRightIcon, LockKeyholeIcon } from 'lucide-vue-next'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { Button } from '@/views/components/ui/button'

const props = defineProps<{
    status?: string;
}>()

const formSchema = toTypedSchema(z.object({
    password: z.string().min(8),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    password: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset('password')
        },
    })
})
</script>

<template>
    <AuthLayout title="Confirm Password" full-width>

        <section class="w-full max-w-80 space-y-6">

            <Stack items="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Confirm password</h1>
                <p class="text-muted-foreground">
                    This is a secure area of the application. Please confirm your password
                    before continuing.
                </p>
            </Stack>

            <form class="space-y-4" @submit.prevent="onSubmit">

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

                <Button
                    type="submit"
                    variant="accent"
                    :disabled="form.processing"
                    block
                >
                    Confirm
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

            </form>

        </section>

    </AuthLayout>
</template>

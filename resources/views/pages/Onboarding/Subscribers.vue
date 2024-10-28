<script setup lang="ts">
import OnboardingLayout from '@/views/layouts/OnboardingLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { FormControl, FormField, FormItem, FormMessage } from '@/views/components/ui/form'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{
    status?: string;
}>()

const formSchema = toTypedSchema(z.object({
    subscriber_1: z.string().email().optional(),
    subscriber_2: z.string().email().optional(),
    subscriber_3: z.string().email().optional(),
    subscriber_4: z.string().email().optional(),
    subscriber_5: z.string().email().optional(),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    subscriber_1: '',
    subscriber_2: '',
    subscriber_3: '',
    subscriber_4: '',
    subscriber_5: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('onboarding.subscribers.store'))
})

const onSkip = () => {
    const emptyForm = inertiaForm({
        subscriber_1: '',
        subscriber_2: '',
        subscriber_3: '',
        subscriber_4: '',
        subscriber_5: '',
    })

    emptyForm.post(route('onboarding.subscribers.store'))
}

const subscribers = <Array<{
    key: string,
    label: string
}>>[
    { key: 'subscriber_1', label: 'me@icloud.com' },
    { key: 'subscriber_2', label: 'spouse@gmail.com' },
    { key: 'subscriber_3', label: 'best.friend@aol.com' },
    { key: 'subscriber_4', label: 'roommate@comcast.net' },
    { key: 'subscriber_5', label: 'someone.else@protonmail.com' },
]
</script>

<template>
    <OnboardingLayout title="Add subscribers">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle>Add subscribers</CardTitle>
                <CardDescription>
                    Add friends and family to your subscriber list to help you get started.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <Stack
                    as="form"
                    class="w-full gap-4"
                    @submit.prevent="onSubmit"
                >

                    <Input
                        v-for="subscriber in subscribers"
                        v-model="form[subscriber.key]"
                        type="email"
                        :key="subscriber.key"
                        :name="subscriber.key"
                        :placeholder="subscriber.label"
                    />

                    <Button
                        variant="accent"
                        type="submit"
                        class="w-full"
                    >
                        Continue
                    </Button>

                    <div class="w-full text-xs text-muted-foreground text-center">
                        Don't worry, they won't get notified until you post.
                    </div>

                </Stack>
            </CardContent>
        </Card>

        <Button
            type="submit"
            variant="outline"
            size="lg"
            class="text-muted-foreground w-full max-w-md"
            @click="onSkip"
        >
            Skip for now
        </Button>
    </OnboardingLayout>
</template>

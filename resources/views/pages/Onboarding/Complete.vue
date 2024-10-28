<script setup lang="ts">
import OnboardingLayout from '@/views/layouts/OnboardingLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{
    blog: App.Models.Blog
}>()

const onSubmit = () => {
    inertiaForm({}).post(route('onboarding.complete.store'))
}
</script>

<template>
    <OnboardingLayout title="All set!">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle>All set!</CardTitle>
                <CardDescription>
                    Head on over to
                    <a
                        :href="route('blogs.show', {blog: blog.slug})"
                        target="_blank"
                        class="text-primary font-medium underline underline-offset-2"
                    >
                        {{ route('blogs.show', {blog: blog.slug}) }}
                    </a>
                    and tell the world about {{ blog.name }}.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <Stack
                    as="form"
                    class="w-full gap-4"
                    @submit.prevent="onSubmit"
                >

                    <Button
                        variant="accent"
                        type="submit"
                        class="w-full"
                    >
                        Let's do this!
                    </Button>

                </Stack>
            </CardContent>
        </Card>
    </OnboardingLayout>
</template>

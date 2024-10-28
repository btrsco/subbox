<script setup lang="ts">
import OnboardingLayout from '@/views/layouts/OnboardingLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Input } from '@/views/components/ui/input'
import { RequiredAsterisk } from '@/views/components/bespoke/required-asterisk'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { useForm as inertiaForm, usePage } from '@inertiajs/vue3'
import { Textarea } from '@/views/components/ui/textarea'
import { route } from 'ziggy-js'
import { ref } from 'vue'
import { slugify } from '@/scripts/lib/utils'

const $page = usePage()
const props = defineProps<{
    status?: string;
}>()

const manuallySetSlug = ref(false)
const placeholderName = $page.props.auth.user?.name + '\'s ' + $page.props.app.name
const placeholderSlug = slugify(placeholderName)

const formSchema = toTypedSchema(z.object({
    name: z.string().min(3).max(255),
    slug: z.string().min(3).max(32),
    bio: z.string().max(1024).optional(),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    name: placeholderName,
    slug: placeholderSlug,
    bio: '',
})

const onSubmit = handleSubmit((values) => {
    form.post(route('onboarding.blog.store'))
})

const handleSlug = (event: Event, force: boolean = false) => {
    const value = (event.target as HTMLInputElement).value

    if ( !force && manuallySetSlug.value) {
        return
    }

    form.slug = slugify(value)
}
</script>

<template>
    <OnboardingLayout title="Set up your blog">
        <Card class="w-full max-w-md">
            <CardHeader>
                <CardTitle>Set up your blog</CardTitle>
                <CardDescription>
                    Start writing and sharing your thoughts with the world.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <Stack
                    as="form"
                    @submit.prevent="onSubmit"
                    class="w-full gap-4"
                >

                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.name"
                        name="name"
                        :validate-on-blur="false"
                    >
                        <FormItem class="space-y-1 w-full">

                            <FormLabel>Name
                                <RequiredAsterisk tooltip="Name is required" />
                            </FormLabel>

                            <FormControl
                                as="div"
                                class="relative"
                            >
                                <Input
                                    v-bind="componentField"
                                    type="text"
                                    placeholder="Name your blog"
                                    @keyup="(e: Event) => handleSlug(e)"
                                />
                            </FormControl>

                            <FormMessage name="name" />

                        </FormItem>
                    </FormField>

                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.slug"
                        name="slug"
                        :validate-on-blur="false"
                    >
                        <FormItem class="space-y-1 w-full">

                            <FormLabel>URL
                                <RequiredAsterisk tooltip="Name is required" />
                            </FormLabel>

                            <FormControl
                                as="div"
                                class="relative"
                            >
                                <Stack
                                    direction="row"
                                    class=""
                                >
                                    <div class="flex items-center h-9 rounded-md border border-input bg-muted text-muted-foreground px-3 py-1 text-sm shadow-sm rounded-r-none border-r-0">
                                        {{ route('home') }}/
                                    </div>

                                    <Input
                                        v-bind="componentField"
                                        type="text"
                                        placeholder="blog-name"
                                        class="rounded-l-none"
                                        @change="(e: Event) => handleSlug(e, true)"
                                        @keyup="manuallySetSlug = true"
                                    />
                                </Stack>
                            </FormControl>

                            <FormMessage name="slug" />

                        </FormItem>
                    </FormField>

                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.bio"
                        name="bio"
                        :validate-on-blur="false"
                    >
                        <FormItem class="space-y-1 w-full">

                            <FormLabel>Bio</FormLabel>

                            <FormControl
                                as="div"
                                class="relative"
                            >
                                <Textarea
                                    v-bind="componentField"
                                    placeholder="Say something about yourself..."
                                    rows="3"
                                />
                            </FormControl>

                            <FormMessage name="bio" />

                        </FormItem>
                    </FormField>

                    <Button
                        variant="accent"
                        type="submit"
                        class="w-full"
                    >
                        Continue
                    </Button>


                </Stack>
            </CardContent>
        </Card>
    </OnboardingLayout>
</template>

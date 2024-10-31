<script setup lang="ts">
import { computed } from 'vue'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { FormButton } from '@/views/components/ui/form'
import { ArrowRightIcon, MailCheckIcon } from 'lucide-vue-next'
import { Button } from '@/views/components/ui/button'
import { Link } from '@inertiajs/vue3'

const props = defineProps<{
    status?: string;
}>()

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>

<template>
    <AuthLayout title="Email Verification" full-width>

        <section class="w-full max-w-80 space-y-6">

            <Stack items="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Email verification</h1>
                <p class="text-muted-foreground">
                    Before getting started, you must verify your email address. If you didn't receive the
                    email, we will gladly send you another.
                </p>
            </Stack>

            <Stack
                v-if="verificationLinkSent"
                direction="row"
                justify="center"
                items="center"
                class="text-sm gap-2 text-green-700 dark:text-green-500">
                <MailCheckIcon class="size-4" />
                A new verification link has been sent to you.
            </Stack>

            <FormButton v-else route="verification.send" block>
                Resend verification email
                <ArrowRightIcon class="size-4 ml-2" />
            </FormButton>

            <Button
                :as="Link"
                :href="route('dashboard.settings.account.edit')"
                variant="secondary"
                block>
                Update email address
                <ArrowRightIcon class="size-4 ml-2" />
            </Button>

        </section>

    </AuthLayout>
</template>

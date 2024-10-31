<script setup lang="ts">

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/views/components/ui/card'
import { CheckIcon } from 'lucide-vue-next'
import { Button } from '@/views/components/ui/button'
import ShowRecoveryCodes from '@/views/pages/Dashboard/Settings/Security/Partials/ShowRecoveryCodes.vue'
import CompleteTwoFactorSetupDialog from '@/views/pages/Dashboard/Settings/Security/Partials/CompleteTwoFactorSetupDialog.vue'
import DisableTwoFactorDialog from '@/views/pages/Dashboard/Settings/Security/Partials/DisableTwoFactorDialog.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { timestamp } from '@vueuse/core'

const props = defineProps<{
    twoFactorEnabled?: boolean
    twoFactorVerified?: boolean
    twoFactorSvg?: string
    status?: string
}>()

const recentlyEnabled = reactive({
    enabled: false,
    timestamp: null as number | null,
})

const enableTwoFactor = () => {
    if (props.twoFactorEnabled) return

    router.post(route('two-factor.enable'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            recentlyEnabled.enabled = true
            recentlyEnabled.timestamp = timestamp()
        },
    })
}
</script>

<template>

    <Card>

        <CardHeader>

            <CardTitle>Two-factor authentication</CardTitle>
            <CardDescription>
                Two-factor authentication adds an extra layer of security to your account. Once enabled, you will be
                required to enter a unique code alongside your password when logging in.
            </CardDescription>

        </CardHeader>

        <CardContent v-if="props.twoFactorEnabled" class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <Stack v-if="!twoFactorVerified" class="gap-1">
                <h2 class="text-primary font-semibold leading-none tracking-tight">Almost there!</h2>
                <p class="text-muted-foreground text-sm">
                    You have enabled two-factor authentication, but you have not yet verified your setup.
                </p>
                <CompleteTwoFactorSetupDialog
                    v-if="recentlyEnabled.enabled || !props.twoFactorVerified"
                    :two-factor-enabled="props.twoFactorEnabled"
                    :two-factor-verified="props.twoFactorVerified"
                    :two-factor-svg="props.twoFactorSvg"
                    :status="props.status"
                    :recently-enabled="recentlyEnabled"
                    :default-open="recentlyEnabled.enabled"
                >
                    <Button class="mt-1">Complete two-factor setup</Button>
                </CompleteTwoFactorSetupDialog>
            </Stack>

            <Stack v-else class="gap-1">
                <h2 class="text-primary font-semibold leading-none tracking-tight">
                    Setup complete
                    <CheckIcon class="size-4 inline-block text-green-700 dark:text-green-500" />
                </h2>
                <p class="text-muted-foreground text-sm">
                    Two-factor authentication is enabled on your account. You will be required to enter a unique code
                    alongside your password when logging in.
                </p>
            </Stack>

            <Stack class="gap-1">
                <h2 class="text-primary font-semibold leading-none tracking-tight">Recovery codes</h2>
                <p class="text-muted-foreground text-sm">
                    Ensure you store these recovery codes in a secure password manager, they're important!
                </p>
                <ShowRecoveryCodes
                    :two-factor-enabled="props.twoFactorEnabled"
                    :two-factor-verified="props.twoFactorVerified"
                    class="mt-1"
                />
            </Stack>

        </CardContent>

        <CardFooter class="border-t py-4 space-x-4">

            <template v-if="props.twoFactorEnabled">
                <DisableTwoFactorDialog :two-factor-enabled="props.twoFactorEnabled">
                    <Button variant="destructive">
                        Disable two-factor authentication
                    </Button>
                </DisableTwoFactorDialog>
            </template>

            <Button @click="enableTwoFactor">
                Enable two-factor authentication
            </Button>

        </CardFooter>

    </Card>

</template>

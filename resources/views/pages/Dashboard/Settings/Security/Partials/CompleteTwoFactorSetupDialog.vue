<script setup lang="ts">
import { PinInput, PinInputGroup, PinInputInput } from '@/views/components/ui/pin-input'
import {
    Dialog,
    DialogClose,
    DialogContent, DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { Stack } from '@/views/components/bespoke/stack'
import { Button } from '@/views/components/ui/button'
import { Label } from '@/views/components/ui/label'
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps<{
    twoFactorEnabled?: boolean
    twoFactorVerified?: boolean
    twoFactorSvg?: string
    status?: string
    defaultOpen?: boolean
    recentlyEnabled: {
        enabled: boolean
        timestamp: number | null
    }
}>()

const verificationCode = ref<string[]>([])

const secretKey = reactive({
    secret: '',
    show: false,
    loading: false,
})

const getTwoFactorSecret = () => {
    if ( !props.twoFactorEnabled) return

    secretKey.loading = true

    return fetch(route('two-factor.secret-key'))
    .then(response => response.json())
    .then(data => {
        secretKey.secret = data.secretKey
        secretKey.loading = false
    })
    .catch(error => {
        console.error('Error:', error)
    })
}

const revealSecret = () => {
    if (secretKey.secret === '') {
        getTwoFactorSecret()
    }

    secretKey.show = true
}

const hideSecret = () => {
    secretKey.show = false
}

const verifyCode = () => {
    if (verificationCode.value.length !== 6) return

    router.post(route('two-factor.confirm'), {
        code: verificationCode.value.join(''),
    }, {
        preserveScroll: true,
        only: ['twoFactorVerified', 'status'],
        onSuccess: () => {
            if( props.status !== 'two-factor-authentication-confirmed') return

        },
    })
}

getTwoFactorSecret()
</script>

<template>
    <Dialog :default-open="defaultOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>

        <DialogContent>

            <DialogHeader>
                <DialogTitle>Complete two-factor setup</DialogTitle>
                <DialogDescription>
                    Use an authenticator app or browser extension to scan the QR code below.
                </DialogDescription>
            </DialogHeader>

            <Stack justify="center" items="center">
                <div class="p-4 border shadow bg-background text-primary rounded-xl mx-auto">
                    <div v-html="props.twoFactorSvg"></div>
                </div>
            </Stack>

            <p class="text-primary text-sm">
                Unable to scan the QR code? You can use the setup key to manually configure
                your authenticator app.
                <span
                    v-if="!secretKey.show"
                    class="text-primary underline-offset-4 underline cursor-pointer"
                    @click="revealSecret"
                >Reveal setup key.</span>
                <span
                    v-else
                    class="text-primary underline-offset-4 underline cursor-pointer"
                    @click="hideSecret"
                >Hide setup key.</span>
            </p>

            <div
                v-if="secretKey.show"
                class="bg-secondary text-sm text-muted-foreground text-center rounded-lg p-4"
            >
                <p v-if="secretKey.loading" class="text-sm text-muted-foreground">Loading setup key...</p>
                <code v-else class="text-sm text-primary">{{ secretKey.secret }}</code>
            </div>

            <Stack items="center" class="gap-3 mt-4">
                <Label class="font-bold">Verification code</Label>
                <PinInput
                    id="two-factor-code"
                    v-model="verificationCode"
                    placeholder="•"
                >
                    <PinInputGroup>
                        <PinInputInput
                            v-for="(id, index) in 6"
                            :key="id"
                            :index="index"
                        />
                    </PinInputGroup>
                </PinInput>
            </Stack>

            <DialogFooter class="flex w-full">
                <DialogClose as-child>
                    <Button variant="outline">
                        Cancel
                    </Button>
                </DialogClose>

                <Button
                    type="submit"
                    @click="verifyCode"
                    :disabled="verificationCode.length !== 6"
                >
                    Verify
                </Button>
            </DialogFooter>

        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>

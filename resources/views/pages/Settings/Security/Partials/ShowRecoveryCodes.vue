<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { Button } from '@/views/components/ui/button'
import { HTMLAttributes, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { useClipboard } from '@vueuse/core'
import { CopyIcon } from 'lucide-vue-next'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/views/components/ui/tooltip'
import { cn } from '@/scripts/lib/utils'

const props = defineProps<{
    twoFactorEnabled?: boolean
    twoFactorVerified?: boolean
    class?: HTMLAttributes['class']
}>()

const recoveryCodes = reactive({
    codes: [],
    asString: '',
    loading: false,
    error: false,
})

const getRecoveryCodes = () => {
    if ( !props.twoFactorEnabled) return

    recoveryCodes.loading = true

    return fetch(route('two-factor.recovery-codes'))
        .then(response => response.json())
        .then(data => {
            recoveryCodes.codes = data
            recoveryCodes.loading = false
            recoveryCodes.asString = data.join('\n')
        })
        .catch(error => {
            recoveryCodes.loading = false
            recoveryCodes.error = true
            console.error('Error:', error)
        })
}

const regenerateRecoveryCodes = () => {
    if ( !props.twoFactorEnabled) return

    recoveryCodes.loading = true

    router.post(route('two-factor.recovery-codes'), {}, {
        preserveScroll: true,
        preserveState: true,
    })

    getRecoveryCodes()
}

getRecoveryCodes()

const { copy, copied, isSupported } = useClipboard({
    source: recoveryCodes.asString,
})
</script>

<template>

    <Dialog>

        <DialogTrigger>
            <Button
                variant="outline"
                :class="cn(props.class)"
            >
                Show recovery codes
            </Button>
        </DialogTrigger>

        <DialogContent>

            <DialogHeader>
                <DialogTitle>Recovery codes</DialogTitle>
                <DialogDescription>
                    Store these recovery codes in a secure password manager. They
                    can be used to recover access to your account if you lose your
                    two-factor authentication device.
                </DialogDescription>
            </DialogHeader>

            <div
                v-if="recoveryCodes.loading || recoveryCodes.error"
                class="bg-secondary text-sm text-muted-foreground text-center rounded-lg p-4">
                <span v-if="recoveryCodes.loading">Loading recovery codes...</span>
                <span v-else>An error occurred while loading recovery codes.</span>
            </div>
            <div v-else>
                <ul class="relative text-sm list-disc bg-secondary pr-6 pl-8 py-4 rounded-lg">

                    <TooltipProvider v-if="isSupported">
                        <Tooltip :delay-duration="100" disable-closing-trigger>
                            <TooltipTrigger as-child>
                                <Button
                                    size="icon-sm"
                                    variant="outline"
                                    @click="copy(recoveryCodes.asString)"
                                    :disabled="recoveryCodes.loading"
                                    class="absolute top-4 right-4"
                                >
                                    <CopyIcon class="size-4" />
                                </Button>
                            </TooltipTrigger>
                            <TooltipContent>
                                {{ !copied ? 'Copy' : 'Copied!' }}
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>

                    <li v-for="code in recoveryCodes.codes" :key="code">
                        <code>{{ code }}</code>
                    </li>

                </ul>
            </div>

            <DialogFooter :class="{'flex justify-between': isSupported}">
                <Button
                    variant="destructive"
                    :disabled="recoveryCodes.loading || recoveryCodes.error"
                    @click="regenerateRecoveryCodes"
                >
                    Regenerate recovery codes
                </Button>
            </DialogFooter>

        </DialogContent>

    </Dialog>

</template>

<script setup lang="ts">
import {
    Dialog,
    DialogClose,
    DialogContent, DialogDescription,
    DialogFooter, DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { Button } from '@/views/components/ui/button'
import { router } from '@inertiajs/vue3'

const props = defineProps<{
    twoFactorEnabled?: boolean
}>()

const disableTwoFactor = () => {
    if (!props.twoFactorEnabled) return

    router.delete(route('two-factor.disable'), {
        preserveScroll: true,
    })
}
</script>

<template>

    <Dialog>
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>

        <DialogContent>

            <DialogHeader>
                <DialogTitle>Disable two-factor authentication?</DialogTitle>
                <DialogDescription>
                    Are you sure you want to disable two-factor authentication? You will no longer be
                    required to enter a unique code when logging in. Any saved recovery codes will be
                    invalidated.
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">
                        Cancel
                    </Button>
                </DialogClose>

                <Button variant="destructive" @click="disableTwoFactor">
                    Disable
                </Button>
            </DialogFooter>

        </DialogContent>

    </Dialog>

</template>

<style scoped>

</style>

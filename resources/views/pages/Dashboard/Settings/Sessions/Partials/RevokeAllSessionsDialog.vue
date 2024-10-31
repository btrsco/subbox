<script setup lang="ts">

import { Button } from '@/views/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent, DialogDescription,
    DialogFooter, DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { router, useForm as inertiaForm } from '@inertiajs/vue3'

const onSubmit = () => {
    inertiaForm({}).delete(route('dashboard.settings.sessions.purge'), {
        preserveScroll: true,
        onError: () => console.log(),
        onFinish: () => router.reload(),
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
                <DialogTitle>
                    Revoke all sessions
                </DialogTitle>
                <DialogDescription>
                    <p>
                        Continuing will invalidate all of the sessions listed on this page,
                        <strong>including your current session</strong>. You will be logged out as a result of revoking
                        these sessions.
                    </p>
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Close</Button>
                </DialogClose>
                <Button
                    variant="destructive"
                    @click="onSubmit"
                >
                    Revoke all sessions
                </Button>
            </DialogFooter>
        </DialogContent>

    </Dialog>
</template>

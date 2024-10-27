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
import dayjs from 'dayjs'
import { router, useForm as inertiaForm } from '@inertiajs/vue3'

const props = defineProps<{
    session: App.Models.Session
    isCurrentSession: boolean
}>()

const lastActive = dayjs(props.session.last_activity)
const formattedLastActive = lastActive.format("MMMM D, YYYY")
const lastActiveTime = lastActive.format("h:mm A")

const onSubmit = () => {
    inertiaForm({}).delete(route('settings.sessions.destroy', {
        session: props.session.id
    }), {
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
                    Revoke session
                </DialogTitle>
                <DialogDescription>
                    <p>
                        Continuing will invalidate the session with the IP address
                        <strong>{{ props.session.ip_address }}</strong> that was last active on
                        <strong>{{ formattedLastActive }} {{ lastActiveTime }}</strong>.
                    </p>
                    <p v-if="props.isCurrentSession" class="mt-2 text-primary font-medium">
                        This is your current session, you will be logged out as a result of revoking this session.
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
                    Revoke session
                </Button>
            </DialogFooter>
        </DialogContent>

    </Dialog>
</template>

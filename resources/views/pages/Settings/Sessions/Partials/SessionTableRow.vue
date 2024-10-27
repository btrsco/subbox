<script setup lang="ts">
import dayjs from 'dayjs'
import { BotIcon, BoxIcon, MonitorIcon, SmartphoneIcon, TabletIcon } from 'lucide-vue-next'
import { TableCell, TableRow } from '@/views/components/ui/table'
import { Button } from '@/views/components/ui/button'
import RevokeSessionDialog from '@/views/pages/Settings/Sessions/Partials/RevokeSessionDialog.vue'

const props = defineProps<{
    session: App.Models.Session
    isCurrentSession: boolean
}>()

const lastActive = dayjs(props.session.last_activity)
const formattedLastActive = lastActive.format("MMMM D, YYYY")
const mobileLastActive = lastActive.format("MM/DD/YY")
const lastActiveTime = lastActive.format("h:mm A")
</script>

<template>
    <TableRow>
        <TableCell>
            <MonitorIcon
                v-if="props.session.device_type === 'desktop'"
                class="size-4"
            />
            <TabletIcon
                v-else-if="props.session.device_type === 'tablet'"
                class="size-4"
            />
            <SmartphoneIcon
                v-else-if="props.session.device_type === 'mobile'"
                class="size-4"
            />
            <BotIcon
                v-else-if="props.session.device_type === 'robot'"
                class="size-4"
            />
            <BoxIcon
                v-else
                class="size-4"
            />
        </TableCell>
        <TableCell>
            <div class="font-bold">
                {{ props.session.device }}
                <span
                    v-if="isCurrentSession"
                    class="font-medium text-muted-foreground italic"
                >(Current)</span>
            </div>
            <div>{{ props.session.browser }}</div>
        </TableCell>
        <TableCell>{{ props.session.ip_address }}</TableCell>
        <TableCell class="text-right">
            <div class="hidden md:block">{{ formattedLastActive }}</div>
            <div class="md:hidden">{{ mobileLastActive }}</div>
            <div class="text-muted-foreground">{{ lastActiveTime }}</div>
        </TableCell>
        <TableCell class="text-center">

            <RevokeSessionDialog
                :session="props.session"
                :is-current-session="props.isCurrentSession"
            >
                <Button variant="destructive" size="xs" class="text-sm">
                    Revoke
                </Button>
            </RevokeSessionDialog>

        </TableCell>
    </TableRow>
</template>

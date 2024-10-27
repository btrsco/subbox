<script setup lang="ts">
import DashboardSettingsLayout from '@/views/layouts/Dashboard/DashboardSettingsLayout.vue'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/views/components/ui/card'
import {
    Table,
    TableBody,
    TableHead,
    TableHeader,
    TableRow,
} from '@/views/components/ui/table'
import { Button } from '@/views/components/ui/button'
import SessionTableRow from '@/views/pages/Settings/Sessions/Partials/SessionTableRow.vue'
import RevokeAllSessionsDialog from '@/views/pages/Settings/Sessions/Partials/RevokeAllSessionsDialog.vue'

const props = defineProps<{
    status?: string
    sessions?: Array<App.Models.Session>
    currentSession?: string
}>()
</script>

<template>
    <DashboardSettingsLayout
        title="Session Settings"
        heading="Sessions"
        subheading="Manage the list of devices that have logged into your account."
        :count="props.sessions?.length"
    >

        <Card>

            <CardHeader>
                <CardTitle>Your sessions</CardTitle>
                <CardDescription>This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.</CardDescription>
            </CardHeader>

            <CardContent>

                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-4"></TableHead>
                            <TableHead>Device</TableHead>
                            <TableHead>IP Address</TableHead>
                            <TableHead class="text-right">Last Active</TableHead>
                            <TableHead class="text-center w-24">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <SessionTableRow
                            v-for="session in props.sessions"
                            :session="session"
                            :is-current-session="session.id === props.currentSession"
                        />
                    </TableBody>
                </Table>

            </CardContent>

            <CardFooter class="border-t py-4 space-x-4">
                <RevokeAllSessionsDialog>
                    <Button
                        type="submit"
                        variant="destructive"
                    >
                        Revoke all sessions
                    </Button>
                </RevokeAllSessionsDialog>
            </CardFooter>

        </Card>

    </DashboardSettingsLayout>
</template>

<script setup lang="ts">
import DashboardLayout from '@/views/layouts/DashboardLayout.vue'
import DashboardPageHeading from '@/views/layouts/Dashboard/Partials/DashboardPageHeading.vue'
import { SubscriptionPagination } from '@/types'
import { Stack } from '@/views/components/bespoke/stack'
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from '@/views/components/ui/table'
import { CheckCircleIcon, EllipsisIcon, TrashIcon, XCircleIcon } from 'lucide-vue-next'
import { useDayjs } from '@/scripts/lib/dayjs'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/views/components/ui/dropdown-menu'
import { Button } from '@/views/components/ui/button'
import { useForm as inertiaForm } from '@inertiajs/vue3'
import MiniPagination from '@/views/pages/Dashboard/Partials/MiniPagination.vue'
import EmptyState from '@/views/pages/Dashboard/Partials/EmptyState.vue'

const props = defineProps<{
    subscriptions: SubscriptionPagination
}>()

const dayjs = useDayjs()

const onSubmit = (id: number) => {
    inertiaForm({}).delete(route('dashboard.subscribers.destroy', { subscription: id }), {
        preserveScroll: true,
    })
}
</script>

<template>
    <DashboardLayout title="Subscribers">
        <DashboardPageHeading
            heading="Subscribers"
            :count="props.subscriptions.total ?? 0"
        />

        <Stack
            class="w-full"
        >
            <Table v-if="props.subscriptions.data.length > 0">
                <TableHeader>
                    <TableRow>
                        <TableHead>Email</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Verified</TableHead>
                        <TableHead>Subscription date</TableHead>
                        <TableHead class="w-12"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="subscription in props.subscriptions.data">
                        <TableCell>{{ subscription.subscriber?.email }}</TableCell>
                        <TableCell
                            :class="{ 'text-muted-foreground': !subscription.subscriber?.name }"
                        >
                            {{ subscription.subscriber?.name ?? '—' }}
                        </TableCell>
                        <TableCell>
                            <CheckCircleIcon
                                v-if="subscription.email_verified_at"
                                class="text-green-700 dark:text-green-500 size-5"
                            />

                            <XCircleIcon
                                v-else
                                class="text-destructive size-5"
                            />
                        </TableCell>
                        <TableCell>
                            {{ dayjs(subscription.created_at).format('MMMM D, YYYY') }}
                        </TableCell>
                        <TableCell>
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button
                                        variant="ghost"
                                        size="icon-sm"
                                        class="text-muted-foreground"
                                    >
                                        <EllipsisIcon class="size-4"/>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuItem
                                        class="text-destructive focus:text-destructive-foreground focus:bg-destructive"
                                        @click="onSubmit(subscription.id)"
                                    >
                                        <TrashIcon class="size-4 mr-2" />
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <EmptyState v-else>
                <p>
                    You don't have any subscribers yet!
                </p>
            </EmptyState>
        </Stack>

        <MiniPagination :pagination="props.subscriptions" />
    </DashboardLayout>
</template>

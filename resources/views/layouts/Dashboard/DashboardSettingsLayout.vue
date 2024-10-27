<script setup lang="ts">
import DashboardLayout from '@/views/layouts/DashboardLayout.vue'
import { DashboardLayoutProps } from '@/types/layouts'
import { NavigationItem } from '@/types'
import { CircleUserIcon, LockKeyholeIcon, MonitorSmartphoneIcon } from 'lucide-vue-next'

const props = defineProps<DashboardLayoutProps>()

const secondaryNavigation: NavigationItem[] = [
    {
        label: 'Account',
        route: 'settings.account.edit',
        type: 'link',
        icon: CircleUserIcon,
    },
    {
        label: 'Password & Security',
        route: 'settings.security.edit',
        type: 'link',
        icon: LockKeyholeIcon,
    },
    {
        label: 'Sessions',
        route: 'settings.sessions.edit',
        type: 'link',
        icon: MonitorSmartphoneIcon,
    }
]
</script>

<template>

    <DashboardLayout
        :title="props.title"
        :heading="props.heading"
        :subheading="props.subheading"
        :count="props.count"
        :icon="props.icon"
        :full-width="props.fullWidth"
        :secondary-navigation="props.secondaryNavigation || secondaryNavigation"
    >
        <slot />
    </DashboardLayout>

</template>

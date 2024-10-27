<script setup lang="ts">
import UpdatePasswordForm from '@/views/pages/Settings/Security/Partials/UpdatePasswordForm.vue'
import DashboardSettingsLayout from '@/views/layouts/Dashboard/DashboardSettingsLayout.vue'
import TwoFactorForm from '@/views/pages/Settings/Security/Partials/TwoFactorForm.vue'

const props = defineProps<{
    twoFactorEnabled?: boolean
    twoFactorVerified?: boolean
    twoFactorSvg?: string
    status?: string
}>()
</script>

<template>
    <DashboardSettingsLayout
        title="Password & Security Settings"
        heading="Password & Security"
        subheading="Update your password and security settings below."
    >
        <UpdatePasswordForm />

        <TwoFactorForm
            :two-factor-enabled="props.twoFactorEnabled"
            :two-factor-verified="props.twoFactorVerified"
            :two-factor-svg="props.twoFactorSvg"
            :status="props.status"
        />

    </DashboardSettingsLayout>
</template>

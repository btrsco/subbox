<script setup lang="ts">
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import DashboardSettingsLayout from '@/views/layouts/Dashboard/DashboardSettingsLayout.vue'

const props = defineProps<{
    mustVerifyEmail?: boolean
    status?: string
}>()
</script>

<template>
    <DashboardSettingsLayout
        title="Account Settings"
        heading="Account"
        subheading="Update your account settings below."
    >

        <UpdateProfileInformationForm
            :must-verify-email="props.mustVerifyEmail"
            :status="props.status"
        />

        <DeleteUserForm />

    </DashboardSettingsLayout>
</template>

<script setup lang="ts">
import { router, useForm as inertiaForm } from '@inertiajs/vue3'
import AuthLayout from '@/views/layouts/AuthLayout.vue'
import { Stack } from '@/views/components/bespoke/stack'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { ArrowRightIcon, ShieldCheckIcon } from 'lucide-vue-next'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'
import { Button } from '@/views/components/ui/button'
import { PinInput, PinInputGroup, PinInputInput } from '@/views/components/ui/pin-input'
import { ref } from 'vue'

const props = defineProps<{
    status?: string
}>()

const verificationCode = ref<string[]>([])
const showRecoveryCodeInput = ref(false)

const formSchema = toTypedSchema(z.object({
    recovery_code: z.string().min(21).max(21),
}))

const { handleSubmit } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    recovery_code: '',
})

const onSubmit = () => {
    console.log('submitting')

    if (showRecoveryCodeInput.value) {
        form.post(route('two-factor.login'), {
            onSuccess: () => {
                if (props.status !== 'two-factor-challenge-passed') return

                router.visit(route('dashboard.home.index'))
            },
        })
    } else {
        if (verificationCode.value.length !== 6) return

        router.post(route('two-factor.login'), {
            code: verificationCode.value.join(''),
        }, {
            preserveScroll: true,
            only: ['twoFactorVerified', 'status'],
            onSuccess: () => {
                if (props.status !== 'two-factor-challenge-passed') return

                router.visit(route('dashboard.home.index'))
            },
        })
    }
}

const toggleRecoveryCodeInput = () => {
    showRecoveryCodeInput.value = !showRecoveryCodeInput.value
}
</script>

<template>
    <AuthLayout
        title="Confirm Authentication Code"
        full-width
    >

        <section class="w-full max-w-80 space-y-6">

            <Stack items="center" class="text-center gap-2">
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Authentication code</h1>
                <p class="text-muted-foreground">
                    This is a secure area of the application. Please confirm your two-factor
                    authentication code before continuing.
                </p>
            </Stack>

            <form class="space-y-4" @submit.prevent="onSubmit">

                <Stack
                    v-if="!showRecoveryCodeInput"
                    justify="center"
                    items="center"
                    @complete="onSubmit"
                >
                    <PinInput
                        v-model="verificationCode"
                        placeholder="•"
                    >
                        <PinInputGroup>
                            <PinInputInput
                                v-for="(id, index) in 6"
                                :key="id"
                                :index="index"
                            />
                        </PinInputGroup>
                    </PinInput>
                </Stack>

                <div v-else>
                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.recovery_code"
                        name="password"
                        :validate-on-blur="false"
                    >
                        <FormItem class="space-y-1">

                            <FormLabel>Recovery code</FormLabel>

                            <FormControl as="div" class="relative">
                                <Input
                                    v-bind="componentField"
                                    type="text"
                                    placeholder="XXXXXXXXXX-XXXXXXXXXX"
                                    class="pl-8"
                                />

                                <FormIconWrapper>
                                    <ShieldCheckIcon class="size-4 text-muted-foreground" />
                                </FormIconWrapper>
                            </FormControl>

                            <FormMessage name="password" />

                        </FormItem>
                    </FormField>
                </div>

                <Button
                    type="submit"
                    variant="accent"
                    :disabled="form.processing || (verificationCode.length !== 6 && !showRecoveryCodeInput)"
                    block
                >
                    Verify
                    <ArrowRightIcon class="size-4 ml-2" />
                </Button>

                <div v-if="!showRecoveryCodeInput" class="text-muted-foreground text-center text-sm">
                    Having issues?
                    <span
                        class="cursor-pointer text-primary underline underline-offset-4"
                        @click="toggleRecoveryCodeInput"
                    >Use recovery code.</span>
                </div>

                <div v-else class="text-muted-foreground text-center text-sm">
                    <span
                        class="cursor-pointer text-primary underline underline-offset-4"
                        @click="toggleRecoveryCodeInput"
                    >Use authentication code.</span>
                </div>

            </form>

        </section>

    </AuthLayout>
</template>

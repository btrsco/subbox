<script setup lang="ts">
import { useForm as inertiaForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Card, CardDescription, CardFooter, CardHeader, CardTitle } from '@/views/components/ui/card'
import { Button } from '@/views/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { LockKeyholeIcon } from 'lucide-vue-next'
import { FormControl, FormField, FormIconWrapper, FormItem, FormLabel, FormMessage } from '@/views/components/ui/form'
import { Input } from '@/views/components/ui/input'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm as veeForm } from 'vee-validate'

const passwordInput = ref<HTMLInputElement | null>(null)
const closeButton = ref<HTMLInputElement | null>(null)

const formSchema = toTypedSchema(z.object({
    password: z.string().min(8),
}))

const { handleSubmit, resetForm } = veeForm({
    validationSchema: formSchema,
})

const form = inertiaForm({
    password: '',
})

const onSubmit = handleSubmit((values) => {
    form.delete(route('dashboard.settings.account.destroy'), {
        preserveScroll: true,
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset()
            resetForm()
        },
    })
})
</script>

<template>

    <Card>

        <CardHeader>

            <CardTitle>Delete account</CardTitle>
            <CardDescription>
                Once your account is deleted, all of its resources and data will be permanently deleted. Before
                deleting your account, please download any data or information that you wish to retain.
            </CardDescription>

        </CardHeader>

        <CardFooter class="border-t py-4">
            <Dialog>
                <DialogTrigger as-child>
                    <Button
                        type="submit"
                        variant="destructive">
                        Delete account
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
                        <DialogDescription>
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            Please enter your password to confirm you would like to permanently delete your account.
                        </DialogDescription>
                    </DialogHeader>

                    <FormField
                        v-slot="{ componentField }"
                        v-model="form.password"
                        name="password"
                        :validate-on-blur="false">
                        <FormItem>

                            <FormLabel>Password</FormLabel>

                            <FormControl as="div" class="relative">
                                <Input
                                    v-bind="componentField"
                                    ref="passwordInput"
                                    type="password"
                                    placeholder="Password"
                                    autocomplete="current-password"
                                    class="pl-8" />

                                <FormIconWrapper>
                                    <LockKeyholeIcon class="size-4 text-muted-foreground" />
                                </FormIconWrapper>
                            </FormControl>

                            <FormMessage name="password" />

                        </FormItem>
                    </FormField>

                    <DialogFooter>
                        <DialogClose as-child>
                            <Button ref="closeButton" type="button" variant="secondary">
                                Close
                            </Button>
                        </DialogClose>

                        <Button type="submit" variant="destructive" @click="onSubmit">
                            Delete account
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </CardFooter>

    </Card>

</template>

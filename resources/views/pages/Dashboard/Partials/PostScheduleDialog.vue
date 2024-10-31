<script setup lang="ts">
import { cn } from '@/scripts/lib/utils'
import { CalendarDate, DateFormatter, type DateValue, getLocalTimeZone, today } from '@internationalized/date'
import {
    Dialog, DialogClose,
    DialogContent,
    DialogDescription, DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/views/components/ui/dialog'
import { Button } from '@/views/components/ui/button'
import { CalendarIcon } from 'lucide-vue-next'
import { Popover, PopoverContent, PopoverTrigger } from '@/views/components/ui/popover'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/views/components/ui/select'
import { Stack } from '@/views/components/bespoke/stack'
import { Label } from '@/views/components/ui/label'
import { Calendar } from '@/views/components/ui/calendar'
import { useDayjs } from '@/scripts/lib/dayjs'
import { onMounted, ref, watch } from 'vue'

const props = defineProps<{
    //
}>()

const emits = defineEmits<{
    (e: 'update:date', value: string): void
    (e: 'update:hour', value: string): void
    (e: 'update:minute', value: string): void
    (e: 'schedule', value: boolean): void
}>()

const dayjs = useDayjs(getLocalTimeZone())
const minimumDate = today(getLocalTimeZone())
const isDialogOpen = ref(false)

const getValidHour = (value: string) => {
    const currentHour = dayjs().hour()
    const currentMinute = dayjs().minute()
    const selectedHour = Number(value)

    return currentHour === selectedHour && currentMinute > 55
        ? (currentHour + 1).toString()
        : value.toString()
}

const getValidMinuteMultiple = (value: string) => {
    const currentHour = dayjs().hour()
    const currentMinuteMultiple = Math.ceil(dayjs().minute() / 5)
    const selectedHour = Number(hour.value)
    const selectedMinuteMultiple = Math.ceil(Number(value) / 5)

    return currentHour === selectedHour && currentMinuteMultiple > selectedMinuteMultiple
        ? currentMinuteMultiple.toString()
        : selectedMinuteMultiple.toString()
}

const date = ref<DateValue>(today(getLocalTimeZone()))
const hour = ref<string>(getValidHour(dayjs().hour().toString()))
const minuteMultiple = ref<string>(getValidMinuteMultiple(dayjs().minute().toString()))

watch([date, hour, minuteMultiple], ([date, hour, minuteMultiple]) => {
    const formattedDate = date?.toDate(getLocalTimeZone()).toISOString()
    const correctedMinutes = (Number(minuteMultiple) * 5).toString()

    emits('update:date', formattedDate)
    emits('update:hour', hour)
    emits('update:minute', correctedMinutes)
})

onMounted(() => {
    const formattedDate = date.value?.toDate(getLocalTimeZone()).toISOString()
    const correctedMinutes = (Number(minuteMultiple.value) * 5).toString()

    emits('update:date', formattedDate)
    emits('update:hour', hour.value)
    emits('update:minute', correctedMinutes)
})

const dateFormatter = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const datePresets = [
    { value: 0, label: 'Today' },
    { value: 1, label: 'Tomorrow' },
    { value: 3, label: 'In 3 days' },
    { value: 7, label: 'In a week' },
]

const updateDate = (value: string) => {
    if ( !value) return
    date.value = today(getLocalTimeZone()).add({ days: Number(value) })
}

const hourIsDisabled = (hour: number) => {
    if (date.value) {
        const isToday = dayjs().isSame(date.value.toDate(getLocalTimeZone()), 'day')
        return isToday && hour < dayjs().hour() || (hour === dayjs().hour() && dayjs().minute() > 55)
    }

    return false
}

const minuteIsDisabled = (minute: number) => {
    if (date.value) {
        const isToday = dayjs().isSame(date.value.toDate(getLocalTimeZone()), 'day')
        const isEndOfHour = dayjs().minute() > 55
        return isToday && hour.value === dayjs().hour().toString() && minute * 5 < dayjs().minute() && !isEndOfHour
    }

    return false
}

const updateDialog = (isOpen: boolean) => {
    if (isOpen) {
        hour.value = getValidHour(hour.value)
        minuteMultiple.value = getValidMinuteMultiple(minuteMultiple.value)
    }

    isDialogOpen.value = isOpen
}

const schedulePost = () => {
    emits('schedule', true)
    isDialogOpen.value = false
}
</script>

<template>
    <Dialog
        :open="isDialogOpen"
        @update:open="updateDialog"
    >
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>When would you like to schedule this post?</DialogTitle>
                <DialogDescription>
                    Choose a date and time to schedule this post to be published.
                </DialogDescription>

                <Stack
                    direction="column"
                    items="center"
                    class="gap-4 py-4 w-full"
                >
                    <div class="grid grid-cols-4 items-center gap-4 w-full">
                        <Label class="text-right">Date</Label>
                        <Popover>
                            <PopoverTrigger as-child>
                                <Button
                                    variant="outline"
                                    :class="cn('w-full justify-start text-left font-normal col-span-3',!date && 'text-muted-foreground')"
                                >
                                    <CalendarIcon class="mr-2 h-4 w-4" />
                                    {{ date ? dateFormatter.format(date.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="flex w-auto flex-col gap-y-2 p-2">
                                <Select @update:model-value="updateDate">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="item in datePresets"
                                            :key="item.value"
                                            :value="item.value.toString()"
                                        >
                                            {{ item.label }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <Calendar
                                    v-model="date"
                                    :min-value="new CalendarDate(minimumDate.year, minimumDate.month, minimumDate.day)"
                                />
                            </PopoverContent>
                        </Popover>
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4 w-full">
                        <Label class="text-right">Time</Label>
                        <Stack
                            direction="row"
                            class="gap-2 col-span-3 items-center"
                        >
                            <Select v-model="hour">
                                <SelectTrigger>
                                    <SelectValue placeholder="Hour" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="hour in 24"
                                        :key="hour"
                                        :value="hour.toString()"
                                        :disabled="hourIsDisabled(hour)"
                                    >
                                        {{ (hour > 12 ? hour - 12 : hour).toString().padStart(2, '0') }}
                                        {{ hour > 12 ? 'PM' : 'AM' }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>

                            <Select v-model="minuteMultiple">
                                <SelectTrigger>
                                    <SelectValue placeholder="Minutes" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        value="0"
                                        :disabled="minuteIsDisabled(0)"
                                    >
                                        00
                                    </SelectItem>
                                    <SelectItem
                                        v-for="minuteMultiple in 11"
                                        :key="minuteMultiple"
                                        :value="minuteMultiple.toString()"
                                        :disabled="minuteIsDisabled(minuteMultiple)"
                                    >
                                        {{ (minuteMultiple * 5).toString().padStart(2, '0') }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </Stack>
                    </div>
                </Stack>
            </DialogHeader>

            <DialogFooter class="flex w-full">
                <DialogClose as-child>
                    <Button
                        ref="closeButton"
                        variant="outline"
                    >
                        Cancel
                    </Button>
                </DialogClose>

                <Button
                    variant="accent"
                    type="submit"
                    @click="schedulePost"
                >
                    Schedule post
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

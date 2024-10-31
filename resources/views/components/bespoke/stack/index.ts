import { cva, type VariantProps } from 'class-variance-authority'

export { default as Stack } from './Stack.vue'

export const stackVariants = cva(
    'flex',
    {
        variants: {
            direction: {
                row: 'flex-row',
                column: 'flex-col',
            },
            items: {
                start: 'items-start',
                center: 'items-center',
                end: 'items-end',
                stretch: 'items-stretch',
                baseline: 'items-baseline',
            },
            justify: {
                start: 'justify-start',
                center: 'justify-center',
                end: 'justify-end',
                between: 'justify-between',
                around: 'justify-around',
                evenly: 'justify-evenly',
            },
            wrap: {
                none: 'flex-no-wrap',
                wrap: 'flex-wrap',
                reverse: 'flex-wrap-reverse',
            },
        },
        defaultVariants: {
            direction: 'column',
            items: 'start',
            justify: 'start',
            wrap: 'none',
        },
    },
)

export type StackVariants = VariantProps<typeof stackVariants>;

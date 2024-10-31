import { cva, type VariantProps } from 'class-variance-authority'

export { default as TextSeparator } from './TextSeparator.vue'

export const textSeparatorVariants = cva(
    '',
    {
        variants: {
            size: {
                sm: 'text-sm',
                base: 'text-base',
                lg: 'text-lg',
                none: '',
            },
        },
        defaultVariants: {
            size: 'none',
        },
    },
)

export type TextSeparatorVariants = VariantProps<typeof textSeparatorVariants>;

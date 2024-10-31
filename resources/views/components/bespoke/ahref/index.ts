import { cva, type VariantProps } from 'class-variance-authority'

export { default as Ahref } from './Ahref.vue'

export const ahrefVariants = cva(
    'underline-offset-4 hover:underline',
    {
        variants: {
            variant: {
                default: 'text-primary',
                muted: 'text-muted-foreground',
                destructive: 'text-destructive',
            },
            size: {
                sm: 'text-sm',
                base: 'text-base',
                lg: 'text-lg',
                none: '',
            },
            underline: {
                false: '',
                true: 'hover:underline',
            },
        },
        defaultVariants: {
            variant: 'default',
            size: 'none',
        },
    },
)

export type AhrefVariants = VariantProps<typeof ahrefVariants>

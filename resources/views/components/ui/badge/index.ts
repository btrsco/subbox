import { cva, type VariantProps } from 'class-variance-authority'

export { default as Badge } from './Badge.vue'

export const badgeVariants = cva(
    'inline-flex items-center rounded-md border px-1.5 py-0.5 text-[0.6875rem] leading-none font-semibold transition-colors ' +
    'focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2',
    {
        variants: {
            variant: {
                default: 'border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80',
                secondary: 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
                destructive: 'border-transparent bg-destructive text-destructive-foreground shadow hover:bg-destructive/80',
                outline: 'text-foreground',
                gray: 'border-transparent bg-neutral-400/20 text-neutral-600 hover:bg-neutral-400/25 dark:bg-neutral-600 ' +
                    'dark:text-white dark:hover:bg-neutral-600/80',
                red: 'border-transparent bg-red-400/20 text-red-600 hover:bg-red-400/25 dark:bg-red-600 dark:text-white ' +
                    'dark:hover:bg-red-600/80',
                orange: 'border-transparent bg-orange-400/20 text-orange-600 hover:bg-orange-400/25 dark:bg-orange-600 ' +
                    'dark:text-white dark:hover:bg-orange-600/80',
                amber: 'border-transparent bg-amber-400/20 text-amber-600 hover:bg-amber-400/25 dark:bg-amber-600 ' +
                    'dark:text-white dark:hover:bg-amber-600/80',
                yellow: 'border-transparent bg-yellow-400/30 text-yellow-700 hover:bg-yellow-400/35 dark:bg-yellow-600 ' +
                    'dark:text-white dark:hover:bg-yellow-600/80',
                lime: 'border-transparent bg-lime-400/30 text-lime-700 hover:bg-lime-400/35 dark:bg-lime-600 ' +
                    'dark:text-white dark:hover:bg-lime-600/80',
                green: 'border-transparent bg-green-400/30 text-green-700 hover:bg-green-400/35 dark:bg-green-600 ' +
                    'dark:text-white dark:hover:bg-green-600/80',
                emerald: 'border-transparent bg-emerald-400/20 text-emerald-600 hover:bg-emerald-400/25 ' +
                    'dark:bg-emerald-600 dark:text-white dark:hover:bg-emerald-600/80',
                teal: 'border-transparent bg-teal-400/20 text-teal-600 hover:bg-teal-400/25 dark:bg-teal-600 ' +
                    'dark:text-white dark:hover:bg-teal-600/80',
                cyan: 'border-transparent bg-cyan-400/20 text-cyan-600 hover:bg-cyan-400/25 dark:bg-cyan-600 ' +
                    'dark:text-white dark:hover:bg-cyan-600/80',
                sky: 'border-transparent bg-sky-400/20 text-sky-600 hover:bg-sky-400/25 dark:bg-sky-600 ' +
                    'dark:text-white dark:hover:bg-sky-600/80',
                blue: 'border-transparent bg-blue-400/20 text-blue-600 hover:bg-blue-400/25 dark:bg-blue-600 ' +
                    'dark:text-white dark:hover:bg-blue-600/80',
                indigo: 'border-transparent bg-indigo-400/20 text-indigo-600 hover:bg-indigo-400/25 dark:bg-indigo-600 ' +
                    'dark:text-white dark:hover:bg-indigo-600/80',
                violet: 'border-transparent bg-violet-400/20 text-violet-600 hover:bg-violet-400/25 dark:bg-violet-600 ' +
                    'dark:text-white dark:hover:bg-violet-600/80',
                purple: 'border-transparent bg-purple-400/20 text-purple-600 hover:bg-purple-400/25 dark:bg-purple-600 ' +
                    'dark:text-white dark:hover:bg-purple-600/80',
                fuchsia: 'border-transparent bg-fuchsia-400/20 text-fuchsia-600 hover:bg-fuchsia-400/25 ' +
                    'dark:bg-fuchsia-600 dark:text-white dark:hover:bg-fuchsia-600/80',
                pink: 'border-transparent bg-pink-400/20 text-pink-600 hover:bg-pink-400/25 dark:bg-pink-600 ' +
                    'dark:text-white dark:hover:bg-pink-600/80',
                rose: 'border-transparent bg-rose-400/20 text-rose-600 hover:bg-rose-400/25 dark:bg-rose-600 ' +
                    'dark:text-white dark:hover:bg-rose-600/80',
            },
        },
        defaultVariants: {
            variant: 'default',
        },
    },
)

export type BadgeVariants = VariantProps<typeof badgeVariants>

import { PageProps as InertiaPageProps } from '@inertiajs/core'
import { Config as ZiggyConfig, route as ZiggyRoute } from 'ziggy-js'
import { PageProps as AppPageProps } from './'
import { ErrorBag, Errors } from '@inertiajs/core/types/types'

declare global {
    let $page: {
        component: string
        props: InertiaPageProps & AppPageProps & {
            errors: Errors & ErrorBag
        }
        url: string
        version: string | null
    }

    let route: typeof ZiggyRoute
    let Ziggy: typeof ZiggyConfig & { location: string }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ZiggyRoute
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {
    }
}

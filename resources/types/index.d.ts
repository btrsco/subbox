import { Config as ZiggyConfig } from 'ziggy-js'
import { MetaConfig } from '@/scripts/types/config/meta'
import { SocialConfig } from '@/scripts/types/config/social'
import { type Component } from 'vue'

declare namespace PageProps {
    export interface User {
        id: number
        name: string
        email: string
        email_verified_at: string
    }

    export interface App {
        name: string
        locale: string
        meta: MetaConfig
        social: SocialConfig
    }
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: PageProps.User | null
    }
    app: PageProps.App
    ziggy: ZiggyConfig & { location: string }
};

export type AsTag =
    'a' | 'button' | 'div' | 'form' | 'h1' | 'h2' | 'h3' | 'img'
    | 'input' | 'label' | 'li' | 'nav' | 'ol' | 'p' | 'span' | 'svg'
    | 'ul' | 'template' | 'textarea' | 'section' | 'header' | 'footer'
    | 'main' | 'aside' | 'article' | 'figure' | 'figcaption'
    | 'blockquote' | 'pre' | 'code'
    | ({} & string)

export interface NavigationItem {
    label: string
    type: 'link' | 'form' | 'label' | 'separator'
    icon?: string | Component
    route: string & {}
    params?: string | number | Array | Object
    current?: string
}

export type Theme = 'light' | 'dark' | 'system'

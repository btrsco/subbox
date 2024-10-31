import { Config as ZiggyConfig } from 'ziggy-js'
import { MetaConfig } from '@/scripts/types/config/meta'
import { SocialConfig } from '@/scripts/types/config/social'
import { type Component } from 'vue'

declare namespace PageProps {
    export interface App {
        name: string
        locale: string
        meta: MetaConfig
        social: SocialConfig
    }
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: App.Models.User | null
        email_verified: boolean | null
        blog: App.Models.Blog | null
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

export type Pagination = {
    current_page: number
    data: Array<any>
    first_page_url: string | null
    from: number | null
    last_page: number
    last_page_url: string | null
    links: Array<{
        url: string | null
        label: string
        active: boolean
    }>
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: number | null
    total: number
}

export type PostStatus = 'published' | 'draft' | 'scheduled' | 'archived'

export type PostOrder = 'newest' | 'oldest' | 'updated' | 'title'

export type PostCounts = {
    published: number
    drafts: number
    scheduled: number
}

// Paginated Model Types

export interface PostPagination extends Pagination {
    data: App.Models.Post[]
}

export interface SubscriptionPagination extends Pagination {
    data: App.Models.Subscription[]
}

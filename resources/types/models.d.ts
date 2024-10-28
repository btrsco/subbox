declare namespace App.Models {
    export type User = {
        id: number
        name: string
        email: string
        email_verified_at: string | null
        last_logged_in_at: string | null
        last_active_at: string | null
        created_at: string | null
        updated_at: string | null

        // Relationships
        blog?: App.Models.Blog | null
        metrics?: Array<App.Models.Metric> | null
        sessions?: Array<App.Models.Session> | null
    }

    export type Metric = {
        id: number
        measurable_id: number
        measurable_type: string
        key: string
        value: number
        year: number
        month: number
        created_at: string | null
        updated_at: string | null

        // Relationships
        measurable?: App.Models.User | null
    }

    export type Session = {
        id: string
        user_id: number
        ip_address: string
        user_agent: string
        last_activity: string
        browser: string
        device: string
        device_type: 'desktop' | 'tablet' | 'mobile' | 'robot' | string
    }

    export type Blog = {
        id: number
        user_id: number
        name: string
        slug: string
        bio: string
        created_at: string | null
        updated_at: string | null

        // Relationships
        user?: App.Models.User | null

        // Computed
        url?: string
    }

    export type Subscription = {
        id: number
        subscriber_id: number
        subscriber_type: string
        blog_id: number
        verification_token?: string
        email_verified_at: string | null
        created_at: string | null
        updated_at: string | null
        deleted_at: string | null

        // Relationships
        subscriber?: Subscriber | null
        blog?: App.Models.Blog | null
    }

    export type Subscriber = App.Models.User | App.Models.EmailSubscriber

    export type EmailSubscriber = {
        id: number
        email: string
        name: string | null
        created_at: string | null
        updated_at: string | null

        // Relationships
        subscriptions?: Array<App.Models.Subscription> | null
    }
}

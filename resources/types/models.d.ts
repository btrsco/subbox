declare namespace App.Models {
    export type User = {
        id: number
        name: string
        email: string
        role: App.Enums.UserRole
        email_verified_at: string | null
        last_logged_in_at: string | null
        last_active_at: string | null
        created_at: string | null
        updated_at: string | null
        metrics?: Array<App.Models.Metric> | null
    }

    export type Metric = {
        id: number
        measurable_id: number
        measurable_type: string
        measurable?: App.Models.User | null
        key: string
        value: number
        year: number
        month: number
        created_at: string | null
        updated_at: string | null
    }

    export type Passkey = {
        id: string
        aaguid: string
        alias: string
        origin: string
        public_key: string
        attestation_format: string
        disabled_at: string | null
        created_at: string | null
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
}

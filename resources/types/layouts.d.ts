import { type Component } from 'vue'
import { NavigationItem } from '@/types'

export interface LayoutProps {
    title: string
}

export interface AppLayoutProps extends LayoutProps {
    // ...
}

export interface OnboardingLayoutProps extends LayoutProps {
    blog?: App.Models.Blog
}

export interface BlogLayoutProps extends LayoutProps {
    emailVerified: boolean
    firstVisit: boolean
    blog: App.Models.Blog
    narrow?: boolean
    status?: string
}

export interface AuthLayoutProps extends LayoutProps {
    hideNavigation?: boolean
    fullWidth?: boolean
}

export interface DashboardLayoutProps extends LayoutProps {
    heading?: string
    subheading?: string
    count?: number
    icon?: string | Component
    fullWidth?: boolean
    secondaryNavigation?: NavigationItem[]
}

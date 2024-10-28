import { type Component } from 'vue'
import { NavigationItem } from '@/types'

export interface LayoutProps {
    title: string
}

export interface AppLayoutProps extends LayoutProps {
    // ...
}

export interface OnboardingLayout extends LayoutProps {
    blog?: App.Models.Blog
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

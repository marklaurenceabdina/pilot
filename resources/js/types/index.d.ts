import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    // Add the new fields for user management
    student_id?: string;
    program?: string;
    year?: string;
    role: 'Member' | 'Officer' | 'Admin';
    status: 'active' | 'inactive' | 'pending';
    last_login: string;
    // Optional fields that might be useful
    first_name?: string;
    middle_name?: string;
    last_name?: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

// Add additional interfaces for user management
export interface UserStats {
    total: number;
    active: number;
    inactive: number;
    admins: number;
    officers: number;
    members: number;
}

export interface UserFormData {
    name: string;
    email: string;
    studentId: string;
    program: string;
    year: string;
    role: 'Member' | 'Officer' | 'Admin';
    status: 'active' | 'inactive';
    lastLogin: string;
}
export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface SocialLinkItem {
    title: string;
    url: string;
    image: string | null;
}

export interface SlideItem {
    id: number;
    imageUrl: string;
    alt?: string;
    link?: string;
}

export interface HomeSettings {
    hero_title?: string | null;
    hero_subtitle?: string | null;
    hero_text_color: string;
    logo?: string | null;
}

export interface PageSeoItem {
    meta_title?: string | null;
    meta_description?: string | null;
    og_image?: string | null;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    app_url?: string;
    auth: {
        user?: User & { role_id?: number };
    };
    social_links?: SocialLinkItem[];
    slides?: SlideItem[];
    home?: HomeSettings;
    page_seo?: Record<string, PageSeoItem>;
};

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

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user?: User & { role_id?: number };
    };
    social_links?: SocialLinkItem[];
    slides?: SlideItem[];
};

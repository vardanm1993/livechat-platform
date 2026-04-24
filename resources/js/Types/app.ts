export interface AuthUser {
    id: number;
    name: string;
    email: string;
}

export interface AppContext {
    name: string;
    locale: string;
    url: string;
}

export interface SharedPageProps {
    app: AppContext;
    auth: {
        user: AuthUser | null;
    };
}

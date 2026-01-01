import type { User } from "../Models";

const BASE_URL = import.meta.env.VITE_API_BASE_URL as string;

if (!BASE_URL) {
    throw new Error("api url alanı girilmedi.");
}

export async function getUsers(signal?: AbortSignal): Promise<User[]> {
    const res = await fetch(`${BASE_URL}/users`, { signal });

    if (!res.ok) {
        throw new Error(`HTTP ${res.status}`);
    }

    const data: User[] = await res.json();
    return data;
}
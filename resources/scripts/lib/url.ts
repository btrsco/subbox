export function slugify(value: string, maxLength: number = 32): string {
    return value
    .toLowerCase()
    .replace(/ /g, '-')
    .replace(/[^a-z0-9-]/g, '')
    .substring(0, maxLength)
}

export function url(path: string): string {
    path = path.startsWith('/') ? path : '/' + path
    return route('home') + path
}

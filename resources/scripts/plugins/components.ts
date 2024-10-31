import { App } from 'vue'
import { Link } from '@inertiajs/vue3'

const Components = {
    install(app: App) {
        registerComponents(app, {
            'inertia-link': Link,
        })
    },
}

export default Components

function registerComponents(app: App, components: Record<string, any>) {
    for (const [name, component] of Object.entries(components)) {
        app.component(name, component)
    }
}

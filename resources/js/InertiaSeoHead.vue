<script setup>
import {onMounted, ref} from 'vue'
import {useTitle} from '@vueuse/core'
import {Head, router, usePage} from '@inertiajs/vue3'

const props = defineProps({
    includeNotificationsCount: {
        type: Boolean,
        default: false
    },
    notifications: {
        type: [String, Number, null],
        default: null
    },
    metaKey: {
        type: String,
        default: 'meta'
    }
})

const meta = ref(usePage().props[props.metaKey])
const key = ref(new Date().toDateString())

function formatTitle(title) {
    if (title === null) {
        title = 'untitled'
    }

    if (props.includeNotificationsCount) {
        const notificationsCount = props.notifications
        if (notificationsCount > 0) {
            return `(${notificationsCount}) ${title}`
        }
    }

    return title
}

function applyMeta(event = null) {
    meta.value = usePage().props[props.metaKey]
    key.value = event ? (event.timeStamp + event.detail.page.component) : new Date().toDateString()

    useTitle(formatTitle(meta.value?.title))
    document.querySelector('meta[name="description"]').setAttribute('content', meta.value?.description ?? '')
}

router.on('success', (event) => applyMeta(event))
onMounted(() => applyMeta())
</script>

<template>
    <div :key="key">
        <Head
            :description="meta?.description"
            :title="formatTitle(meta?.title)"/>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'
    defineProps({
        links: Array
    });
</script>

<template>
    <nav v-if="links.length > 4">
        <ul class="pagination pagination-sm sm-0 float-right">
            <li class="page-item"
                :class="[
                link.url === null ? 'disabled' : '',
                link.active ? 'active' : ''
                ]"
                v-for="(link, index) in links"
                :key="index"
            >
                <Link class="page-link"
                    :href="link.url === null ? '#' : link.url"
                    v-html="link.label"
                ></Link>
            </li>
        </ul>
    </nav>
</template>

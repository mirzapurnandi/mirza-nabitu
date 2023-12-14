
<template>
    <div class="p-5 mb-4 bg-light rounded-3">
        <app-header />
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Header from './components/layouts/Header.vue'

export default {
    components: {
        'app-header': Header
    }
}
</script>

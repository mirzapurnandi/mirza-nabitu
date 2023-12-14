
<template>
    <div class="p-5 mb-4 bg-light rounded-3">
        <app-header v-if="isAuth" />
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Header from './components/layouts/Header.vue'

export default {
    computed: {
        ...mapState(['token']),
        ...mapGetters(['isAuth'])
    },
    components: {
        'app-header': Header
    }
}
</script>

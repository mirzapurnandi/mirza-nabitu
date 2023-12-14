<template>
    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <router-link :to="{ name: 'home' }" class="nav-link px-2 text-secondary">
                            Home
                        </router-link>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-2 text-white">About</a>
                    </li>
                </ul>

                <div class="text-end">
                    <router-link :to="{ name: 'home' }" class="btn btn-outline-light me-2">
                        Logout
                    </router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    //
}
</script>
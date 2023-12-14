<template>
    <div class="card border-0 mt-5 w-50 m-auto rounded shadow">
        <div class="card-body">
            <form>
                <h1 class="h3 mb-5 fw-normal">Please sign in</h1>

                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="btn btn-primary w-100" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Login'
}
</script>
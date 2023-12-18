<template>
    <div class="card border-0 rounded shadow">
        <h5 class="card-header">Reminder Create</h5>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="title" value="entry title">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'AddReminder',

}
</script>
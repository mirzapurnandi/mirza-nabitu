<template>
    <div class="card border-0 rounded shadow">
        <h5 class="card-header">Reminder Create</h5>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.title }" name="title"
                        value="entry title" v-model="reminder.title">
                    <span class="error invalid-feedback" v-if="errors.title">{{ errors.title[0] }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" :class="{ 'is-invalid': errors.description }" name="description"
                        v-model="reminder.description"></textarea>
                    <span class="error invalid-feedback" v-if="errors.description">{{ errors.description[0] }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="remind_at" class="col-sm-2 col-form-label">Reminder At</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" :class="{ 'is-invalid': errors.remind_at }" name="remind_at"
                        value="" v-model="remind_at" @input="updateRemindAt">
                    <span class="error invalid-feedback" v-if="errors.remind_at">{{ errors.remind_at[0] }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="event_at" class="col-sm-2 col-form-label">Event At</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" :class="{ 'is-invalid': errors.event_at }" name="event_at"
                        value="" v-model="event_at" @input="updateEventAt">
                    <span class="error invalid-feedback" v-if="errors.event_at">{{ errors.event_at[0] }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" @click.prevent="submit" :disabled="this.processing">
                <div class="spinner-border spinner-border-sm" role="status" v-if="this.processing">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Tambah
            </button>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
    name: 'AddReminder',

    data() {
        return {
            reminder: {
                title: '',
                description: '',
                remind_at: '',
                event_at: '',
            },
            remind_at: '',
            event_at: '',
        }
    },
    computed: {
        ...mapState(['errors', 'processing']),
    },

    methods: {
        ...mapActions('reminder', ['createReminder']),

        submit() {
            this.createReminder(this.reminder).then(() => {
                this.$router.push({ name: 'reminder.data' });
            })
        },
        updateRemindAt() {
            const dateObject = new Date(this.remind_at);
            this.reminder.remind_at = dateObject.getTime() / 1000; // Dibagi 1000 untuk mendapatkan detik
        },
        updateEventAt() {
            const dateObject = new Date(this.event_at);
            this.reminder.event_at = dateObject.getTime() / 1000; // Dibagi 1000 untuk mendapatkan detik
        },
    }
}
</script>
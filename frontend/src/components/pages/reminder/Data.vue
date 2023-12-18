<template>
    <div class="card border-0 rounded shadow">
        <h5 class="card-header">Reminder List</h5>
        <div class="card-body">
            <router-link :to="{ name: 'reminder.add' }" class="btn btn-primary btn-sm"> Create </router-link>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Reminder At</th>
                        <th>Event At</th>
                        <th style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(val, index) in reminder" :key="val.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ val.title }}</td>
                        <td>{{ val.description }}</td>
                        <td>{{ val.remind_at }}</td>
                        <td>{{ val.event_at }}</td>
                        <td>
                            <router-link :to="{ name: 'reminder.edit', params: { id: val.id } }"
                                class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                            &nbsp;&nbsp;
                            <button class="btn btn-danger btn-sm" @click="deleteReminder(val.id)"><i
                                    class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataReminder',
    created() {
        this.getReminder()
    },
    data() {
        return {
            datas: [],
            search: ''
        }
    },
    computed: {
        ...mapState('reminder', {
            reminder: state => state.reminder
        }),
    },
    methods: {
        ...mapActions('reminder', ['getReminder', 'removeReminder']),

        deleteReminder(id) {
            this.removeReminder(id).then(() => {
                this.$router.go({ name: 'reminder.data' });
            })
        }
    }
}
</script>
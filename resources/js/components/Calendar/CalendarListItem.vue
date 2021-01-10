<template>
     <b-list-group-item class="event_registered" v-if="isEventDay(day)"> 
        <b-row>
            <b-col cols="4">{{ `${day.day} ${day.day_of_week}` }}</b-col>
            <b-col>{{ insertedEvent.eventName }}</b-col>
        </b-row>
    </b-list-group-item>

    <b-list-group-item v-else> 
        <b-row >
            <b-col>{{ `${day.day} ${day.day_of_week}` }}</b-col>
        </b-row>
    </b-list-group-item>
</template>

<script>
    export default {
        name: "CalendarListItem",
        props: ["insertedEvent", "day"],
        methods: {
            isEventDay(day){
                return this.insertedEvent != null && (
                    (this.insertedEvent.days).includes(day.day_of_week) && 
                        (day.date >= this.insertedEvent.startDate && day.date <= this.insertedEvent.endDate));
            }
        },
    }
</script>

<style scoped>
    .event_registered{
        background: #d4edda;
    }
</style>
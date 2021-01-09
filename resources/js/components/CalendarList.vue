<template>
    <div>
        <h3>{{ monthYearDisplay }}</h3>
        <b-list-group>
                <b-list-group-item v-for="day in calendar" :key="day.day">
                <b-row 
                    class="bg-success" 
                    v-if="insertedEvent != null && 
                        ((insertedEvent.days).includes(day.day_of_week) && 
                         (day.date >= insertedEvent.startDate && day.date <= insertedEvent.endDate))">
                    <b-col cols="3">{{ day.day + ' ' + day.day_of_week }}</b-col>
                    <b-col>{{ insertedEvent.eventName }}</b-col>
                </b-row>
                <b-row v-else>
                    <b-col>{{ `${day.day} ${day.day_of_week}` }}</b-col>
                </b-row>
            </b-list-group-item>
        </b-list-group>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "CalendarList",
        props: ["insertedEvent"],
        data(){
            return {
                monthYearDisplay: moment().format('MMMM YYYY'),
                calendar: []
            }
        },
        created(){
            let startOfCurrentMonth =  moment().startOf('month');
            let endOfCurrentMonth   =  moment().endOf('month').add(1, 'days');

            while (startOfCurrentMonth.isBefore(endOfCurrentMonth, 'day')) {
                this.calendar.push({
                    date: startOfCurrentMonth.format('YYYY-MM-DD'),
                    day: startOfCurrentMonth.format('DD'),
                    day_of_week: startOfCurrentMonth.format('ddd'),
                });
                startOfCurrentMonth.add(1, 'days');
            }
        }
    }
</script>
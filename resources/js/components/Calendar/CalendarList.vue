<template>
    <div>
        <h3>{{ monthYearDisplay }}</h3>
        <b-list-group>
            <div v-for="day in calendar" :key="day.day">
               <CalendarListItem :insertedEvent="insertedEvent" :day="day"></CalendarListItem>
            </div>
        </b-list-group>
    </div>
</template>

<script>
    import moment from 'moment';
    import CalendarListItem from './CalendarListItem';

    export default {
        name: "CalendarList",
        components: {
            CalendarListItem
        },
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
                    day: startOfCurrentMonth.format('D'),
                    day_of_week: startOfCurrentMonth.format('ddd'),
                });
                startOfCurrentMonth.add(1, 'days');
            }
        }
    }
</script>

<style scoped>

</style>
<template>
    <!-- b-container -->
    <b-container fluid class="m-2">
        
        <b-alert v-if="success"
            variant="success"
            :show="dismissCountDown"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged" fade>
                <b-icon icon="check" aria-hidden="true"></b-icon>{{ message }}
        </b-alert>

        <b-alert v-else
            variant="danger"
            :show="dismissCountDown"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged">
                <b-icon icon="x-circle" aria-hidden="true"></b-icon>
                {{ message }}
        </b-alert>

        <!-- b-card -->
        <b-card title="Calendar" class="shadow-sm">
            <b-card-text>
                <b-row>
                    <b-col lg="4">
                        <b-form>
                        <b-form-group
                            id="input-group-1"
                            label="Event"
                            label-for="input-1">
                            <b-form-input 
                                id="event_name" 
                                v-model="event.eventName" 
                                type="text"
                                v-bind:class="{ 'is-invalid': validationErrors.eventName ? true : false }"></b-form-input>
                        </b-form-group>
                        <ul class="list-unstyled text-left text-danger">
                            <li v-for="item in validationErrors.eventName" :key="item">
                                {{ item }}
                            </li>
                        </ul>
                    <b-row>
                        <b-col>
                            <b-form-group label="From">
                                <b-form-datepicker 
                                    v-bind:min="minDate"
                                    v-bind:max="maxDate"
                                    v-model="event.startDate" 
                                    class="mb-2"
                                    v-bind:class="{ 'is-invalid': validationErrors.startDate ? true : false }"></b-form-datepicker>
                            </b-form-group>
                            <ul class="list-unstyled text-left text-danger">
                                <li v-for="item in validationErrors.startDate" :key="item">
                                    {{ item }}
                                </li>
                            </ul>
                        </b-col>
                        <b-col>
                            <b-form-group label="To">
                                <b-form-datepicker
                                    v-bind:min="minDate"
                                    v-bind:max="maxDate"
                                    v-model="event.endDate" 
                                    class="mb-2" 
                                    v-bind:class="{ 'is-invalid': validationErrors.endDate ? true : false }"></b-form-datepicker>
                            </b-form-group>
                            <ul class="list-unstyled text-left text-danger">
                                <li v-for="item in validationErrors.endDate" :key="item">
                                    {{ item }}
                                </li>
                            </ul>
                        </b-col>
                    </b-row>
                       
                     <b-form-group id="input-group-4">
                        <b-form-checkbox-group id="checkboxes-4">
                            <b-form-checkbox 
                                name="days[]"
                                v-for="day in days" 
                                :key="day" 
                                v-bind:value="day"
                                v-model="event.days">{{ day }}</b-form-checkbox>
                            
                        </b-form-checkbox-group>
                        <ul class="list-unstyled text-left text-danger">
                            <li v-for="item in validationErrors.days" :key="item">
                                {{ item }}
                            </li>
                        </ul>
                    </b-form-group>
                    
                     <b-button 
                        v-if="isLoading"
                        type="button" 
                        variant="primary"
                        disabled>
                        <b-spinner small label="Loading..."></b-spinner></b-button>
                    
                    <b-button 
                        v-else
                        type="button" 
                        variant="primary"
                        v-on:click="onSubmit">
                        Save</b-button>
                        
                   

                </b-form>
            </b-col>

            <b-col lg="8">
             

                    <h3>{{ monthYearDisplay }}</h3>
                    <b-list-group>
                        <b-list-group-item v-for="day in calendar" :key="day.day">
                            <b-row 
                                class="bg-success"
                                v-if="insertedEvent != null && (
                                    (insertedEvent.days).includes(day.day_of_week) && 
                                    (day.date >= insertedEvent.startDate && day.date <= insertedEvent.endDate))">
                                <b-col cols="3">{{ day.day + ' ' + day.day_of_week }}</b-col>
                                <b-col>{{ insertedEvent.eventName }}</b-col>
                            </b-row>
                            <b-row v-else>
                                <b-col>{{ day.day + ' ' + day.day_of_week }}</b-col>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
            </b-col>
            
        </b-row>
    </b-card-text>
  </b-card>
</b-container>
    
</template>

<script>

import moment from 'moment'

export default {
    name: 'App',
    props: [], 
    components: {
        
    },
    data(){
        return {
            isLoading: false,
            monthYearDisplay: moment().format('MMMM YYYY'),
            moment: moment,
            minDate:  moment().startOf('month').format('YYYY-MM-DD'),
            maxDate: moment().endOf('month').format('YYYY-MM-DD'),
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            message: "",
            success: false,
            event: {
                eventName: '',
                startDate: '',
                endDate: '',
                days: []
            },
            insertedEvent: null,
            days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], 
            validationErrors: [],
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
    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        onSubmit(){
            this.isLoading = true;
            let $this = this;

            axios.post(`${BASE_URL}/event`, {
                 ... this.event
            })
            .then(function (response) {
                // loader.hide();
                let {success, message, validation, data} = response.data;
                $this.success = success;
                $this.message = message;
                $this.dismissCountDown = $this.dismissSecs
                $this.isLoading = false;
                if(success){  
                    $this.insertedEvent = {...$this.event};
                    // $this.event.eventName  = null;
                    // $this.event.startDate  = null;
                    // $this.event.endDate    = null;
                    // $this.event.days       = [];
                    $this.validationErrors = [];
                }else{
                    $this.validationErrors = validation;
                }
            })
            .catch(function (error) {
                // loader.hide();
                $this.isLoading = false;
                console.log(error);
            });
        }
    }

}
</script>

<style scoped>
    #result-dialog{
        position: absolute;
        right: 0px;
        min-width: 300px;
        margin-right: 14px;
        z-index: 1;
    }
</style>
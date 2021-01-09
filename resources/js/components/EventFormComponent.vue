<template>
    <b-form>
        <!-- event name -->
        <b-form-group label="Event" label-for="event_name">
            <b-form-input id="event_name" v-model="event.eventName" type="text" 
                v-bind:class="{ 'is-invalid': validationErrors.eventName ? true : false }"></b-form-input>
        </b-form-group>
        
        <!-- display errors for event name --> 
        <ul class="list-unstyled text-left text-danger">
            <li v-for="item in validationErrors.eventName" :key="item">{{ item }}</li>
        </ul>
        
        <!-- date range -->
        <b-row>

            <!-- start date -->
            <b-col>
                <b-form-group label="From">
                    <b-form-datepicker class="mb-2" v-bind:min="minDate" v-bind:max="maxDate" v-model="event.startDate" 
                        v-bind:class="{ 'is-invalid': validationErrors.startDate ? true : false }">
                    </b-form-datepicker>
                </b-form-group>
                <!-- display start date errors -->
                <ul class="list-unstyled text-left text-danger">
                    <li v-for="item in validationErrors.startDate" :key="item">{{ item }}</li>
                </ul>
            </b-col>
            
            <!-- end date-->
            <b-col>
                <b-form-group label="To">
                    <b-form-datepicker class="mb-2" v-bind:min="minDate" v-bind:max="maxDate" v-model="event.endDate" 
                        v-bind:class="{ 'is-invalid': validationErrors.endDate ? true : false }"></b-form-datepicker>
                    </b-form-group>
                    <!-- display end date errors-->
                    <ul class="list-unstyled text-left text-danger">
                         <li v-for="item in validationErrors.endDate" :key="item"> {{ item }}</li>
                    </ul>
            </b-col>
        </b-row>

        <!-- day of the week checkboxes -->              
        <b-form-group>
            <b-form-checkbox-group>
                <b-form-checkbox name="days[]" v-for="day in days" :key="day" 
                    v-bind:value="day" v-model="event.days"> {{ day }}
                </b-form-checkbox>
            </b-form-checkbox-group>
            
            <ul class="list-unstyled text-left text-danger">
                <li v-for="item in validationErrors.days" :key="item">{{ item }}</li>
            </ul>
        </b-form-group>
                    
        <b-button v-if="isLoading" type="button" variant="primary" disabled>
            <b-spinner small label="Loading..."></b-spinner>
        </b-button>
                    
        <b-button v-else type="button" variant="primary" v-on:click="onSubmit">Save</b-button>
                    
    </b-form>
</template>

<script>
    export default {
           
    }
</script>
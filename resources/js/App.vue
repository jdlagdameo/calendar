<template>
    <!-- b-container -->
    <b-container fluid class="m-2">
        
        <b-alert variant="success" fade 
            v-if="success"
            :show="dismissCountDown"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged">
                <b-icon icon="check" aria-hidden="true"></b-icon>{{ message }}
        </b-alert>

        <b-alert variant="danger" fade 
            v-else
            :show="dismissCountDown"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged">
                <b-icon icon="x-circle" aria-hidden="true"></b-icon>{{ message }}
        </b-alert>

        <!-- b-card -->
        <b-card title="Calendar" class="shadow-sm">
            <b-card-text>
                <b-row>
                    <b-col lg="4">
                        <EventFormComponent
                            v-on:createEvent="createEventHandler($event)"
                            :validationErrors="validationErrors"
                            :isLoading="isLoading"></EventFormComponent>
                    </b-col>

                    <b-col lg="8">
                        <CalendarList :insertedEvent="insertedEvent"></CalendarList>        
                    </b-col>
                </b-row>
            </b-card-text>
        </b-card>

</b-container>
    
</template>

<script>

import EventFormComponent from './components/EventFormComponent';
import CalendarList from './components/CalendarList';

export default {
    name: 'App',
    props: [], 
    components: {
        EventFormComponent, CalendarList
    },

    data(){
        return {
            message: "",
            success: false,
            isLoading: false,
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            insertedEvent: null,
            validationErrors: []
        }
    },
    
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        createEventHandler(ev){
            this.isLoading = true;
            
            let $this = this;
           
            axios.post(`${BASE_URL}/event`, {... ev})
            .then(function (response) {
                
                let { success, message, validation, data } = response.data;
                $this.success = success;
                $this.message = message;
                $this.dismissCountDown = $this.dismissSecs
                $this.isLoading = false;

                if(success){  
                    $this.insertedEvent = {... ev};
                    $this.validationErrors = [];
                }else{
                    $this.validationErrors = validation;
                }

            })
            .catch(function (error) {
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
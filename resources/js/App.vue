<template>
    <!-- b-container -->
    <b-container fluid class="m-2">
        <div id="alert-container">
            <div v-for="(result, index) in results" :key="index">
                <b-alert variant="success" fade v-if="result.success" show>
                    <font-awesome-icon icon="check" /> {{ result.message }}
                </b-alert>

                <b-alert variant="danger" fade v-else show>
                    <font-awesome-icon icon="times-circle" /> {{ result.message }}
                </b-alert>
            </div>
        </div>
   
        <!-- b-card -->
        <b-card class="shadow-sm"  header="Calendar">
            <b-card-text>
                <b-row>
                    <b-col lg="4" class="mt-3">
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
import CalendarList from './components/Calendar/CalendarList';

export default {
    name: 'App',
    props: [], 
    components: {
        EventFormComponent, CalendarList
    },

    data(){
        return {
            isLoading: false,
            insertedEvent: null,
            validationErrors: [],
            results:[]
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
                
                let { success, message, validation } = response.data;
                $this.results.push({success: success, message: message});
                $this.dismissCountDown = $this.dismissSecs
                $this.isLoading = false;

                if(success){  
                    $this.insertedEvent = {... ev};
                    $this.validationErrors = [];
                }else{
                    $this.validationErrors = validation;
                }

                setTimeout(function(){ $this.results.shift(); }, 5000);
 

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
    .card-header{
        background: #ffffff;
        font-weight: bold;
        font-size: 16px;
    }
    #alert-container{
        
        width: 300px;
        position: absolute;
        top: 43px;
        right: 6px;
        z-index: 1;

    }
    .alert{
        margin-bottom: 5px;
    }
</style>
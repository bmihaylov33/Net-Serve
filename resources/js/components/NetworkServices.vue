<template>
    <div>
        <div class="card__content">
            <div class="table--heading">
                <p>ID</p>
                <p>Service Name</p>
                <p>Port Name</p>
                <p>Service Type</p>
                <p>Speed</p>
                <p>Status</p>
                <p>Created</p>
            </div>
            <div class="card__content__service" v-if="loading">
                <p><strong>Loading...</strong></p>
            </div>
            <div class="table--items" v-for="service in services" :key="service.id">
                <router-link class="service-link" :to="{ name: 'NetworkService', params: { service_id: service.id }}">{{ service.id }}</router-link>
                <router-link class="service-link" :to="{ name: 'NetworkService', params: { service_id: service.id }}">{{ service.name }}</router-link>
                <p>{{ service.port.name }}</p>
                <p>{{ service.type }}</p>
                <p>{{ service.port.speed }}</p>
                <p>{{ service.status }}</p> 
                <p>{{ service.created }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: true,
            services: [],
        };
    },
    mounted() {
        axios.get('/api/services')
            .then(response => {
                this.services = response.data.services;
                this.loading = false;
            })
            .catch(error => {
                console.error('Error fetching services:', error);
                this.loading = false;
            });
    }
};
</script>


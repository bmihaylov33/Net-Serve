<template>
    <div>
        <div class="card__content__service">
            <div v-if="loading">
                <p><strong>Loading...</strong></p>
            </div>
            <template v-if="service.id">
                <div class="service-details">
                    <div class="section">
                        <div class="card__header__section">
                            <h2 class="card__title__section">Service Details</h2>
                        </div>
                        <p><strong>Service ID:</strong> {{ service.id }}</p>
                        <p><strong>Service Name:</strong> {{ service.name }}</p>
                        <p><strong>Type:</strong> {{ service.type }}</p>
                        <p><strong>Status:</strong> {{ service.status }}</p>
                        <p><strong>Bandwidth:</strong> {{ service.bandwidth }}</p>
                        <p><strong>Created:</strong> {{ service.created }}</p>
                        <p><strong>Expires:</strong> {{ service.expires }}</p>
                        <p><strong>Pricing Model:</strong> {{ service.pricing_model }}</p>
                    </div>

                    <div class="section" v-if="service.port">
                        <div class="card__header__section">
                            <h2 class="card__title__section">Port Details</h2>
                        </div>
                        <p><strong>Port Name:</strong> {{ service.port.name }}</p>
                        <p><strong>Port Speed:</strong> {{ service.port.speed }}</p>
                        <p><strong>Committed Bandwidth:</strong> {{ service.port.committed_bandwidth }}</p>
                        <p><strong>Utilization:</strong> {{ service.port.utilisation }}</p>
                    </div>

                    <div class="section" v-if="service.b_port">
                        <div class="card__header__section">
                            <h2 class="card__title__section">B Port Details</h2>
                        </div>
                        <p><strong>B Port Name:</strong> {{ service.b_port.name }}</p>
                        <p><strong>B Port Speed:</strong> {{ service.b_port.speed }}</p>
                        <p><strong>B Port Committed Bandwidth:</strong> {{ service.b_port.committed_bandwidth }}</p>
                        <p><strong>B Port Utilization:</strong> {{ service.b_port.utilisation }}</p>
                    </div>

                    <div class="section" v-if="service.csp_status">
                        <div class="card__header__section">
                            <h2 class="card__title__section">CSP Status</h2>
                        </div>
                        <p><strong>Color:</strong> {{ service.csp_status.color }}</p>
                        <p><strong>Text:</strong> {{ service.csp_status.text }}</p>
                        <p><strong>State:</strong> {{ service.csp_status.state }}</p>
                    </div>

                    <div class="section">
                        <div class="card__header__section">
                            <h2 class="card__title__section">Statistics</h2>
                        </div>
                        <p><strong>2 Way Latency:</strong> {{ service.statistics['2_way_latency'].lastvalue }}</p>
                        <p><strong>FE FL:</strong> {{ service.statistics['fe_fl'].lastvalue }}</p>
                        <p><strong>Jitter:</strong> {{ service.statistics['jitter'].lastvalue }}</p>
                        <p><strong>NE FL:</strong> {{ service.statistics['ne_fl'].lastvalue }}</p>
                        <p><strong>Total:</strong> {{ service.statistics['total'].lastvalue }}</p>
                        <p><strong>Discards:</strong> {{ service.statistics['discards'].lastvalue }}</p>
                        <p><strong>Conform:</strong> {{ service.statistics['conform'].lastvalue }}</p>
                    </div>
                </div>
            </template>
            <template v-else-if="!loading">
                <div class="section">
                    <p><strong>No service data available.</strong></p>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "NetworkService",
    data() {
        return {
            loading: true,
            service: [],
        };
    },
    props: {
        service_id: {
        required: true,
        type: String
        }
    },
    mounted() {
        axios.get('/api/services/' + this.service_id)
        .then(response => {
            this.service = response.data;
            this.loading = false;
        })
        .catch(error => {
            console.error('Error getting service info:', error);
            this.loading = false;
        });
    }
};
</script>

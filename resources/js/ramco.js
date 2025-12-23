import { createApp } from "vue";

createApp({
    data() {
        return {
            headers: window.ramcoHeaders || [],
            selectedHeader: null,
            details: [],
        };
    },

    methods: {
        selectHeader(header) {
            this.selectedHeader = header;
            this.details = header.details || [];
        },

        formatAmount(value) {
            return Number(value).toFixed(2);
        },
    },
}).mount("#app");

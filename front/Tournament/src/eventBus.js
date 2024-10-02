// eventBus.js
import { ref } from 'vue';
const EventBus = ref(new Map());

export default {
    on(event, callback) {
        EventBus.value.set(event, callback);
    },
    emit(event, data) {
        if (EventBus.value.has(event)) {
            EventBus.value.get(event)(data);
        }
    }
};

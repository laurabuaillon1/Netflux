import { ref } from "vue";

const isVisible = ref(false);
const message = ref('');
const type =ref('success');

export function useAlert(){
    const triggerAlert = (text, alertType = 'success') => {
        message.value = text
        type.value = alertType
        isVisible.value=true

        setTimeout(()=> {
            isVisible.value = false
        },4000) //4secondes
    }

    const closeAlert = () => {
        isVisible.value = false
    }

    return {
        isVisible, 
        message, 
        type, 
        triggerAlert, 
        closeAlert,
    }
}
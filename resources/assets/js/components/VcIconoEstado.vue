<template lang="html">
    
    <div>
        <check-icon
            v-if="estado"
            class="icono"
        >
        </check-icon>
        
        <x-icon
            v-else
            class="icono"
        >
        </x-icon>
    </div>
    
</template>

<script>
import { CheckIcon, XIcon } from 'vue-feather-icons';

export default {
    name: 'vc-icono-estado',
    components: {
        CheckIcon,
        XIcon
    },
    props: {
        estado: {
            type: Boolean,
            required: true
        }
    }
}
</script>

<style lang="css">
</style>

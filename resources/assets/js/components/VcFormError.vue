<template lang="html">
    <div v-if="error" class="invalid-feedback">
        {{ error[0] }}
    </div>
</template>

<script>
export default {
    name: 'vc-form-error',
    props: {
        error : {
            type : Array,
            required: true
        }
    }
}
</script>

<style lang="css">
</style>

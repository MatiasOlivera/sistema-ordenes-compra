<template lang="html">

    <button type="button" name="eliminar" class="btn btn-sm btn-outline-danger">
        <trash-icon class="icono"></trash-icon> Eliminar
    </button>

</template>

<script>
import { TrashIcon } from 'vue-feather-icons';

export default {
    components: { TrashIcon }
}
</script>

<style lang="css">
</style>

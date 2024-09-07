<script setup>
    import { ref } from 'vue'

    const currentDate = ref(new Date)
</script>
<template>
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-{{ currentDate.getFullYear() }} <a href="https://adminlte.io">Admin-o-Matic</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 2.0
        </div>
    </footer>
</template>

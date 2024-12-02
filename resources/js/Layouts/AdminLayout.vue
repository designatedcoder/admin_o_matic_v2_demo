<script setup>
    import { onMounted } from 'vue'
    import { Head } from '@inertiajs/vue3'
    import Navigation from '@/Components/Custom/Navigation.vue'
    import Footer from '@/Components/Custom/Footer.vue'
    import Sidebar from '@/Components/Custom/Sidebar.vue'

    defineProps({
        title: String,
    });

    onMounted(() => {
        let SELECTOR_LOADER = '.preloader'
        setTimeout(() => {
            let $loader = $(SELECTOR_LOADER)
            if ($loader) {
                $loader.css('height', 0)
                setTimeout(() => {
                    $loader.children().hide()
                }, 200);
            }
        }, 2000);
    })
</script>

<template>
    <div class="dark-mode wrapper">

        <Head :title="title" />

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__wobble" :src="'/storage/defaults/images/AdminLTELogo.png'" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <Navigation />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <slot name="header" />
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <slot name="content" />
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <Footer />
    </div>
    <!-- ./wrapper -->

</template>

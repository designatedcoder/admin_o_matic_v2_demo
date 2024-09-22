<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue'

    defineProps({
        permissions: Array
    });
</script>

<template>
    <AdminLayout title="Permissions">
        <template #header>
            <div class="col-sm-6">
                <h1 class="m-0">Permissions</h1>
            </div><!-- /.col -->
        </template>

        <template #content>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Permissions Table</h3>

                            <div class="card-tools">
                               <button type="btn" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th>Created</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in permissions" :key="index">
                                        <td>{{ item.id }}</td>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.display_name }}</td>
                                        <td>{{ item.description }}</td>
                                        <td>{{ item.created_at }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-success">Edit</button>
                                            <button type="button" class="btn btn-danger ml-2">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        <!-- /.row -->
        </template>
    </AdminLayout>
</template>

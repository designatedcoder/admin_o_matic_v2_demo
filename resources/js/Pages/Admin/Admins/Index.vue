<script setup>
    import { ref, computed } from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import Pagination from '@/Components/Custom/Pagination.vue'
    import AdminLayout from '@/Layouts/AdminLayout.vue'

    const props = defineProps({
        admins: Object,
        roles: Array,
    });

    const editedIndex = ref(-1)
    const editMode = ref(false)
    const roleOptions = props.roles

    const form = useForm({
        id: '',
        name: '',
        email: '',
        selectedRoles: []
    })

    const closeModal = () => {
        $('#modal-lg').modal('hide')
        editedIndex.value = -1
        editMode.value = false
        form.reset()
        form.clearErrors()
    };

    const openEdit = (item) => {
        $('#modal-lg').modal('show')
        editedIndex.value = props.admins.data.indexOf(item);
        editMode.value = true
        form.id = item.id
        form.name = item.name
        form.email = item.email
        form.selectedRoles = item.roles
    };

    const editAdmin = () => {
        form.patch(route('admin.admins.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
                Toast.fire({
                    icon: "success",
                    title: "Admin has been updated!"
                })
            }
        })
    }
</script>
<template>
    <AdminLayout title="Admins">
        <template #header>
            <div class="col-sm-6">
                <h1 class="m-0">Admins</h1>
            </div><!-- /.col -->
        </template>

        <template #content>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Admins Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Roles</th>
                                        <th>Created</th>
                                        <th class="text-right"
                                            v-if="$page.props.adminUser.can.updateAdmins"
                                        >Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in props.admins.data" :key="index">
                                        <td>{{ item.id }}</td>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.email }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                               <span v-for="(role, index) in item.roles" :key="index">
                                                    {{ role.name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ item.created_at }}</td>
                                        <td class="text-right"
                                            v-if="$page.props.adminUser.can.updateAdmins"
                                        >
                                            <button type="button" class="btn btn-success" @click.prevent="openEdit(item)">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <Pagination :links="props.admins.links" />
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Current Role</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editAdmin">
                            <div class="modal-body">
                                <div class="card card-primary">
                                    <div class="form-group">
                                        <label for="display_name" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" style="border-radius: .25rem;" disabled v-model="form.name">
                                    </div>
                                    <div class="form-group">
                                        <label for="display_name" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" style="border-radius: .25rem;" disabled v-model="form.email">
                                    </div>

                                    <div class="form-group">
                                        <label for="roles" class="col-form-label" :class="{ 'text-danger' : form.errors.selectedRoles }">Roles</label>
                                        <VueMultiselect
                                            v-model="form.selectedRoles"
                                            :options="roleOptions"
                                            :multiple="false"
                                            :taggable="true"
                                            label="name"
                                            track-by="id"
                                            placeholder="Pick a role"
                                        >
                                        </VueMultiselect>
                                        <div class="invalid-feedback mt-2" :class="{ 'd-block' : form.errors.selectedRoles }">
                                            {{ form.errors.selectedRoles }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" @click.prevent="closeModal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <!-- /.row -->
        </template>
    </AdminLayout>
</template>

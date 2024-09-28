<script setup>
    import { useForm } from '@inertiajs/vue3'
    import AdminLayout from '@/Layouts/AdminLayout.vue'

    defineProps({
        permissions: Array
    });

    const form = useForm({
        name: '',
        display_name: '',
        description: ''
    })

    const nameSlug = () => {
        return slugify(form.display_name.toLowerCase())
    }

    const slugify = (str) => {
        return String(str)
            .normalize('NFKD') // split accented characters into their base characters and diacritical marks
            .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
            .trim() // trim leading or trailing whitespace
            .toLowerCase() // convert to lowercase
            .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
            .replace(/\s+/g, '-') // replace spaces with hyphens
            .replace(/-+/g, '-') // remove consecutive hyphens
    }

    const createPermission = () => {
        form.post(route('admin.permissions.store'), {
            preserveScroll: true,
            onSuccess: () => {
               $('#modal-lg').modal('hide')
            }
        })
    }
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
                                <button type="btn"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-lg"
                                >
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
                                        <td class="text-capitalize">{{ item.display_name }}</td>
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

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create a Permission</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="createPermission">
                            <div class="modal-body">
                                <div class="card card-primary">
                                    <div class="form-group">
                                        <label for="display_name" class="col-form-label">Display Name</label>
                                        <input type="text" class="form-control" style="border-radius: .25rem;" v-model="form.display_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Name (Slug)</label>
                                        <input type="text" class="form-control" style="border-radius: .25rem;" disabled :value="nameSlug(form.display_name)">
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-form-label">Description</label>
                                        <textarea rows="2" class="form-control" style="border-radius: .25rem;" v-model="form.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                   Create
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
      <!-- /.modal -->
        <!-- /.row -->
        </template>
    </AdminLayout>
</template>

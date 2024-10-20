<script setup>
    import { ref, computed } from 'vue'
    import { useForm } from '@inertiajs/vue3'
    import AdminLayout from '@/Layouts/AdminLayout.vue'

    const props = defineProps({
        permissions: Array
    });

    const form = useForm({
        id: '',
        name: '',
        display_name: '',
        description: ''
    })

    const editedIndex = ref(-1)
    const editMode = ref(false)

    const formTitle = computed(() => {
       return editedIndex.value === -1 ? 'Create New Permission' : 'Edit Current Permission'
    });

    const btnTxt = computed(() => {
       return editedIndex.value === -1 ? 'Create' : 'Update'
    });

    const checkMode = computed(() => {
       return editMode.value === false ? createPermission : editPermission
    });

    const openModal = () => {
        $('#modal-lg').modal('show')
    };

    const closeModal = () => {
        $('#modal-lg').modal('hide')
        editedIndex.value = -1
        editMode.value = false
        form.reset()
        form.clearErrors()
    };

    const openEdit = (item) => {
        $('#modal-lg').modal('show')
        editedIndex.value = props.permissions.indexOf(item);
        editMode.value = true
        form.id = item.id
        form.display_name = item.display_name
        form.description = item.description
    };

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
                closeModal()
                Toast.fire({
                    icon: "success",
                    title: "New permission created!"
                })
            }
        })
    }

    const editPermission = () => {
        form.patch(route('admin.permissions.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
                Toast.fire({
                    icon: "success",
                    title: "Permission has been updated!"
                })
            }
        })
    }

    const deletePermission = (item) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.delete(route('admin.permissions.destroy', item.id), {
                    preserveScroll: true,
                    onSuccess: ()=> {
                        Swal.fire(
                            'Deleted!',
                            'Permission has been deleted.',
                            'success'
                        )
                     }
                 })
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
                                <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-lg"
                                    @click.prevent="openModal"
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
                                    <tr v-for="(item, index) in props.permissions" :key="index">
                                        <td>{{ item.id }}</td>
                                        <td>{{ item.name }}</td>
                                        <td class="text-capitalize">{{ item.display_name }}</td>
                                        <td>{{ item.description }}</td>
                                        <td>{{ item.created_at }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-success" @click.prevent="openEdit(item)">Edit</button>
                                            <button type="button" class="btn btn-danger ml-2" @click.prevent="deletePermission(item)">Delete</button>
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
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ formTitle }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="checkMode">
                            <div class="modal-body">
                                <div class="card card-primary">
                                    <div class="form-group">
                                        <label for="display_name" class="col-form-label" :class="{ 'text-danger' : form.errors.display_name }">Display Name</label>
                                        <input type="text" class="form-control" :class="{ 'is-invalid' : form.errors.display_name }" style="border-radius: .25rem;" v-model="form.display_name">
                                        <div class="invalid-feedback mt-2" :class="{ 'd-block' : form.errors.display_name }">
                                            {{ form.errors.display_name }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Name (Slug)</label>
                                        <input type="text" class="form-control" style="border-radius: .25rem;" disabled :value="nameSlug(form.display_name)">
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-form-label" :class="{ 'text-danger' : form.errors.description }">Description</label>
                                        <textarea rows="2" class="form-control" :class="{ 'is-invalid' : form.errors.description }" style="border-radius: .25rem;" v-model="form.description"></textarea>
                                        <div class="invalid-feedback mt-2" :class="{ 'd-block' : form.errors.description }">
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" @click.prevent="closeModal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ btnTxt }}
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

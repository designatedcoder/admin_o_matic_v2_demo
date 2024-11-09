<script setup>
    import { Link, router } from '@inertiajs/vue3'

    const logout = () => {
        router.post(route('logout'));
    };
</script>
<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <Link :href="route('dashboard')" class="brand-link">
            <img :src="'/storage/defaults/images/AdminLTELogo.png'" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Admin-o-Matic</span>
        </Link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="$page.props.auth.user.profile_photo_url" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ $page.props.auth.user.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <Link :href="route('admin.dashboard')" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </Link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Tables
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link :href="route('admin.roles.index')" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.permissions.index')" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.users.index')" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.admins.index')" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admins</p>
                                </Link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">MISCELLANEOUS</li>

                    <li class="nav-item">
                        <Link :href="route('dashboard')" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p>User Dashboard</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <form @submit.prevent="logout">
                            <button type="submit" class="nav-link text-left">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <p>Logout</p>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

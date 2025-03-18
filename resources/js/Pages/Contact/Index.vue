<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const contacts = ref(page.props.contacts);

const onDelete = (e) => {
    contacts.value = e.props.contacts;
};
</script>

<template>
    <Head title="Contacto" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Contactos
                </h2>
                <PrimaryButton>
                    <Link :href="route('contact.create')">
                        Crear Contacto
                    </Link>
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="relative overflow-x-auto">
                        <table
                            className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                className="text-xs text-gray-700 uppercase bg-white border-b"
                            >
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Telefono
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Visibilidad
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Avatar
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="contact in contacts"
                                    className="bg-white border-b"
                                >
                                    <th
                                        scope="row"
                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ contact.name }}
                                    </th>
                                    <td className="px-6 py-4">
                                        {{ contact.phone }}
                                    </td>
                                    <td className="px-6 py-4">
                                        {{ contact.privacity }}
                                    </td>
                                    <td className="px-6 py-4">
                                        <img
                                            :src="`/storage/${contact.avatar}`"
                                            class="w-10 h-10"
                                        />
                                    </td>
                                    <td className="px-6 py-4">
                                        <div
                                            class="flex flex-col md:flex-row md:space-x-5"
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'contact.edit',
                                                        contact
                                                    )
                                                "
                                                class="text-center"
                                            >
                                                Editar
                                            </Link>
                                            <Link
                                                @success="onDelete"
                                                :href="
                                                    route(
                                                        'contact.destroy',
                                                        contact
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                            >
                                                Eliminar
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

const page = usePage();

const contact = ref(page.props.contact);

const initialValues = {
    name: contact.value.name,
    phone: contact.value.phone,
    avatar: null,
    privacity: contact.value.privacity,
};

const form = useForm(initialValues);

const onSelectAvatar = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.avatar = files[0];
    }
};

const onSubmit = () => {
    form.post(route("contact.update", contact.value), {
        onSuccess: (e) => {
            contact.value = e.props.contact;
        },
    });
};
</script>

<template>
    <Head title="Editar Contacto" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar Contacto
                </h2>
                <PrimaryButton>
                    <Link :href="route('contact.index')"> Regresar </Link>
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex justify-center overflow-hidden bg-white shadow-sm rounded-lg"
                >
                    <form
                        class="w-full md:w-1/2 py-5 px-3 space-y-5"
                        @submit.prevent="onSubmit"
                    >
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600"
                            >
                                Usuario Actualizado!
                            </p>
                        </Transition>
                        <div>
                            <InputLabel for="name" value="Nombre" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                                placeholder="Ruiz A."
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="phone" value="Teléfono" />

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                placeholder="+51961100857"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.phone"
                            />
                        </div>
                        <div>
                            <InputLabel for="avatar" value="Avatar" />

                            <FileInput name="avatar" @change="onSelectAvatar" />

                            <InputError
                                class="mt-2"
                                :message="form.errors.avatar"
                            />
                        </div>
                        <div>
                            <img
                                :src="`/storage/${contact.avatar}`"
                                class="w-20 h-20 mx-auto"
                                alt="Avatar"
                            />
                        </div>
                        <div>
                            <InputLabel for="privacity" value="Privacidad" />

                            <select
                                name="privacity"
                                id="privacity"
                                class="mt-1 block rounded-md w-full border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                v-model="form.privacity"
                            >
                                <option value="public">Público</option>
                                <option value="private">Privado</option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="form.errors.privacity"
                            />
                        </div>
                        <PrimaryButton> Actualizar Contacto </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

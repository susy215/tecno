<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Registrarse" />
        <div class="md:flex sm:block rounded-lg  bg-gray-200 shadow-slate-400 shadow-lg">

            <!-- Sección de bienvenida -->
            <div
                class="w-96 rounded-r-3xl rounded-lg bg-gradient-to-r text-center justify-center from-orange-400 to-yellow-400 text-white p-8">
                <div class="flex items-center justify-center w-36 h-36 ml-20 mt-4 bg-yellow-500 rounded-lg shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-24 h-24 text-white">
                        <rect x="20" y="30" width="60" height="50" rx="4" fill="currentColor"/>
                        <path d="M 30 30 L 30 25 Q 30 20 35 20 L 65 20 Q 70 20 70 25 L 70 30" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="40" cy="50" r="3" fill="white"/>
                        <circle cx="60" cy="50" r="3" fill="white"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold -mt-2 mb-3">¡Bienvenido de nuevo!</h2>
                <p class="mb-14">Para mantenerte conectado con nosotros, por favor inicia sesión con tu información
                    personal</p>
                <Link :href="route('login')" type="button"
                    class="bg-white text-orange-500 p-2 px-28 rounded-md hover:bg-gray-200 hover:text-gray-800 hover:scale-110 hover:shadow-lg hover:shadow-yellow-300">
                Iniciar sesión</Link>
            </div>
            <div class="w-96 p-7 pt-10">
                <h2 class="text-3xl font-bold mb-4 text-center">Crear cuenta</h2>
                <form @submit.prevent="submit">
                    <div>
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            autofocus autocomplete="name" placeholder="Nombre de usuario" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autocomplete="email" placeholder="Correo electrónico" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                            required placeholder="Contraseña" autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                            v-model="form.password_confirmation" required placeholder="Confirmar contraseña"
                            autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button
                            class="w-full justify-center h-12 rounded-md bg-[#F7BE38] text-white hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2"
                            :disabled="form.processing">
                            Registrarse
                        </button>
                    </div>
                </form>
                <!-- <div class="flex items-center justify-center mb-4">
                    <div class="border-t  ms-2 border-gray-300 flex-grow mr-3"></div>
                    <span class="text-gray-500 ">o</span>
                    <div class="border-t border-gray-300 flex-grow ml-3"></div>
                </div> -->
                <!-- <div class="flex justify-center">
                    <div class="flex my-4 w-full">
                        <div>
                            <a class="w-full justify-center h-12 rounded-md bg-blue-600 text-white active:bg-blueGray-50 text-blueGray-700 px-4 py-2 outline-none focus:outline-none mr-4 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-sm ease-linear transition-all duration-150"
                                type="button" href="/auth/facebook/redirect">
                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Facebook
                            </a>
                        </div>
                        <a class="w-full justify-center h-12 ml-2 rounded-md bg-white active:bg-blueGray-50 text-blueGray-700 px-4 py-2 outline-none focus:outline-none mr-1  uppercase shadow hover:shadow-md inline-flex items-center font-bold text-sm ease-linear transition-all duration-150"
                            type="button" href="/auth/google/redirect">
                            <img alt="..." class="w-5 mr-1"
                                src="https://demos.creative-tim.com/notus-js/assets/img/google.svg" />Google
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </GuestLayout>
</template>

<template>
    <div>
        <base-panel class="mt-4">
            <h2 class="text-2xl font-medium">Formulario</h2>
            <div class="mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <base-input label="Nombre" placeholder="Nombre" v-model="restaurant.name"></base-input>
                    <base-input label="Descripción" placeholder="Descripción"
                                v-model="restaurant.description"></base-input>
                    <base-input label="Dirección" placeholder="Dirección" v-model="restaurant.address"></base-input>
                    <base-input label="Ciudad" placeholder="Ciudad" v-model="restaurant.city"></base-input>
                    <base-input label="Url de la foto" v-model="restaurant.photo_url"></base-input>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <button class="px-3 mt-4 py-1 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded"
                            @click="sendForm">Send
                    </button>
                    <button class="px-3 mt-4 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded"
                            v-if="restaurant.id != null" @click="deleteRestaurant">Delete
                    </button>
                </div>
            </div>
        </base-panel>

        <base-panel class="mt-4" v-if="restaurant.id != null">
            <h2 class="text-2xl font-medium">Reservas para {{ restaurant.name }}</h2>
            <div class="mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <base-input label="Mesa" type="number" placeholder="Mesa"
                                v-model="reserve.number_table"></base-input>
                    <base-input label="Fecha" type="date" placeholder="YYYY-MM-DD"
                                v-model="reserve.date"></base-input>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <button class="px-3 mt-4 py-1 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded"
                            @click="createReserve">Send
                    </button>
                </div>
            </div>
        </base-panel>

        <base-panel class="mt-4">
            <h2 class="text-2xl font-medium">Lista</h2>
            <base-input type="text" placeholder="Filtrar" v-model="search" @Up="getRestaurants"></base-input>
            <div class="mt-4">
                <div class="flex flex-col">
                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6">
                        <div
                            class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                        style="text-align: start">
                                        Restaurante
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                        style="text-align: start">
                                        Descripcion
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                        style="text-align: start">
                                        Direccion
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                        style="text-align: start">
                                        Numero de reservas
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                </tr>
                                </thead>
                                <tbody class="bg-white">
                                <template v-for="r in restaurants">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full"
                                                         :src="r.photo_url"
                                                         alt=""/>
                                                </div>
                                                <div class="mx-2">
                                                    <div class="text-sm leading-5 font-medium text-gray-900">{{
                                                            r.name
                                                        }}
                                                    </div>
                                                    <div class="text-sm leading-5 text-gray-500">{{ r.city }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ r.description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ r.address }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                            {{ r.reservation.length }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">
                                            <a class="cursor-pointer text-indigo-600 hover:text-indigo-900"
                                               @click="restaurant = r">Editar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-no-wrap border-gray-200">
                                            <ul>
                                                <li v-for="reservation in r.reservation">
                                                    Mesa # {{ reservation.number_table }} para el dia
                                                    {{ reservation.date }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </base-panel>
    </div>
</template>

<script>
axios.defaults.headers.common['Authorization'] = "Bearer " + window.token;

export default {
    name: "Home",
    data() {
        return {
            restaurants: [],
            restaurant: {
                id: null,
                name: null,
                description: null,
                address: null,
                photo_url: null,
                city: null,
                open: false,
            },
            reserve: {
                number_table: null,
                date: null
            },
            search: null,
        }
    },
    mounted() {
        this.getRestaurants();
    },
    methods: {
        getRestaurants() {
            let vm = this;
            axios.get("api/restaurant", {params: {search: vm.search}}).then(response => {
                vm.restaurants = response.data.data;
            });
        },
        sendForm() {
            let vm = this;

            if (vm.restaurant.id === null) {
                vm.createRestaurant();
            }

            if (vm.restaurant.id != null) {
                vm.updateRestaurant();
            }
        },
        createRestaurant() {
            let vm = this;

            axios.post("api/restaurant", vm.restaurant).then(response => {
                vm.getRestaurants();
                vm.clearForm();
            });
        },
        createReserve() {
            let vm = this;
            vm.reserve.restaurant_id = vm.restaurant.id;
            axios.post("api/reserve", vm.reserve).then(response => {
                vm.getRestaurants();
                vm.clearForm();
            }).catch(error => {
                alert(error.response.data.errors.number_table[0]);
            });
        },
        updateRestaurant() {
            let vm = this;
            axios.put("api/restaurant/" + vm.restaurant.id, vm.restaurant).then(response => {
                vm.getRestaurants();
                vm.clearForm();
            });
        },
        deleteRestaurant() {
            let vm = this;
            axios.delete("api/restaurant/" + vm.restaurant.id).then(response => {
                vm.getRestaurants();
                vm.clearForm();
            });
        },
        clearForm() {
            let vm = this;
            vm.restaurant = {
                id: null,
                name: null,
                description: null,
                address: null,
                photo_url: null,
                city: null,
            };
            vm.reserve = {
                number_table: null,
                date: null
            }
            vm.search = null
        },
    },
}
</script>

<style scoped>

</style>

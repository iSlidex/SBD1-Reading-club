<template>
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-log card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">book</i>
                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <h4 class="card-title">Generar reporte para club</h4>
                                </div>
                                <div class="col-lg-2">

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <b-form>

                                        <b-row>
                                            <b-col cols="6">
                                                <h6 class="ml-3"><strong>LISTA DE CLUBES</strong></h6>
                                                <small class="ml-3">Seleccione un club para generar el reporte</small>
                                            </b-col>
                                        </b-row>

                                        <b-row>
                                            <b-col cols="12">
                                                <b-col lg="6" class="my-1">
                                                    <b-form-group label-for="filterInput" class="mb-0">
                                                        <b-input-group size="sm">
                                                            <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                                            <b-input-group-append>
                                                                <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                                <b-table selectable :select-mode="'single'" :items="items" :fields="fields" @row-selected="onRowSelected" responsive="lg" id="my-table" :per-page="perPage" :current-page="currentPage" small sort-by="apellido" :filter="filter" :filterIncludedFields="filterOn" @filtered="onFiltered">
                                                    <!-- Example scoped slot for select state illustrative purposes -->
                                                    <template v-slot:cell(seleccionado)="{ rowSelected }">
                                                        <template v-if="rowSelected">
                                                            <span aria-hidden="true">&check;</span>
                                                            <span class="sr-only">Seleccionado</span>
                                                        </template>
                                                        <template v-else>
                                                            <span aria-hidden="true">&nbsp;</span>
                                                            <span class="sr-only">No seleccionado</span>
                                                        </template>
                                                    </template>
                                                </b-table>
                                            </b-col>
                                        </b-row>
                                        <div class="d-flex flex-row-reverse bd-highlight">
                                            <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>

                                        </div>
                                    </b-form>
                                    <br>

                                    <div class="d-flex flex-row-reverse bd-highlight">
                                        <b-button variant="default" @click="revalidate">Continuar</b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    data() {
        return {
            selected: [],
            perPage: 10,
            currentPage: 1,
            fields: ['seleccionado', 'nombre', 'fecha_de_creacion', 'idioma'],
            items: [],
            selected: [],
            filterOn: [],
            filter: null,
        }
    },

    created() {
        axios.get(`/clubs-reports`)
            .then(res => {
                this.items = res.data.data;
                //console.log(this.obras);
            }).catch(e => {
                console.log(e);
            })
    },
    methods: {
        onRowSelected(items) {
            this.selected = items
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },

        generate() {
            const params = {
                club: this.selected[0].id,
            };

            window.location = `/attendance-reports-groups/${params.club}`;

            /*axios.post(`/reportattendances`, params)
                .then(res => {
                    window.location = `/attendance-reports/${params.club}`;
                }).catch(e => {
                    console.log(e);
                })*/
        },

        revalidate() {
            let msg = '';
            if (this.selected.length == 0) msg = msg + "Seleccione un club<br>";

            if (msg == '') {
                this.generate();
            } else {
                Swal.fire({
                    title: 'Error',
                    html: '<p class="text-center">' + msg + '</p>',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#8C7F7F',
                })
            }
        }
    },

    computed: {
        rows() {
            return this.items.length
        },
    }
}
</script>

<template>
    <v-app>
        <div>
            <h1 class="text-center">Gestion de articulos</h1>
            <hr>

            <template>
                <v-row align="center" justify="space-around">
                    <v-btn @click="addItem()" depressed color="primary">Crear nuevo articulo</v-btn>
                </v-row>
            </template>

            <v-row>
                <v-col cols="12" sm="12" md="12" lg="12" style="margin-top: 0.5em">
                    <template>
                        <v-card>
                            <v-card-title>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                ></v-text-field>
                            </v-card-title>

                            <v-data-table
                                v-model="selected"
                                :headers="headers"
                                :items="articulos"
                                :item-key="primaryIndex"
                                :search="search"
                            >

                                <template v-slot:item.nombre="{ item }">
                                    <span>{{item.nombre}}</span>
                                </template>

                                <template v-slot:item.descripcion="{ item }">
                                    <span>{{item.descripcion}}</span>
                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <v-icon @click="editItem(item)" small class="mr-2">
                                        edit
                                    </v-icon>
                                    <v-icon @click="deleteItem(item)" small>
                                        delete
                                    </v-icon>
                                </template>

                            </v-data-table>
                        </v-card>
                    </template>
                </v-col>

            </v-row>

            <v-dialog
                v-model="dialogForm"
                transition="dialog-top-transition"
                persistent
                max-width="900"
                v-on:keydown.esc.prevent="closeDialogForm()"
            >

                <template>
                    <v-card>
                        <v-toolbar color="primary" dark>
                            <v-toolbar-title v-if="isNewItem">Crear nuevo articulo</v-toolbar-title>
                            <v-toolbar-title v-else>Editar articulo</v-toolbar-title>
                            <div class="flex-grow-1"></div>
                            <v-btn @click="functionSaveItem()" text>Guardar</v-btn>
                            <v-btn @click="closeDialogForm()" text>Cerrar</v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field v-model="rowItem.nombre" 
                                            label="Nombre" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field v-model="rowItem.descripcion" 
                                            label="Descripcion" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field v-model="rowItem.stock" 
                                            label="Stock" required></v-text-field>
                                        </v-col>
                                        <!-- <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="rowItem.email" 
                                            label="Email" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="rowItem.password" label="Password*" type="password" required></v-text-field>
                                        </v-col> -->

                                    </v-row>
                                </v-container>
                            </v-card-text>
                        </v-card-text>
                    </v-card>
                </template>
            </v-dialog>

        </div>
    </v-app>
</template>

<script>


export default{

    data () {
        return {
            dialogForm: false,
            isNewItem: true,
            selected:[],
            primaryIndex: 'id',
            search: '',
            headers: [
                {text: 'ID', value: 'id'},
                {text: 'Nombre', align: 'start', filterable: false, value: 'nombre'},
                {text: 'Descripcion', value: 'descripcion'},
                {text: 'Stock', value: 'stock'},
                {text: 'Creacion', value: 'create_at'},
                {text: 'Actualizacion', value: 'update_at'},
                {text: 'Accion', value: 'actions'},
            ],
            articulos: [],
            rowItem: {},
            controller: 'articulos',
            schemabuilder: 'schemabuilder',
            table: 'articulos',
        }
    },

    mounted(){
        this.getArticulos()
        this.getRowItem()
    },
    methods: {
        functionCheckBox(){
            this.checkbox_fe = !this.checkbox_fe
        },

        getRowItem(){
            axios.get(`${this.schemabuilder}/articulos`).then(response => {
                this.rowItem = response.data.rows;
            })
        },

        getArticulos(){
            axios.get(`${this.controller}`).then(response => {
                this.articulos = response.data;
            })
        },

        deleteItem(item){
            axios.delete(`${this.controller}/`+item.id).then(response => {
                if(response.data.status === 'Success'){
                    this.getArticulos()
                }
            })
        },

        functionSaveItem(){
            if(this.isNewItem){
                this.saveItem()
            } else {
                this.updateItem()
            }
        },

        saveItem(){
            axios.post(`${this.controller}`, this.rowItem).then(response => {
                if(response.data.status === 'Success'){
                    this.closeDialogForm()
                    this.getArticulos()
                }
            })
        },

        updateItem(){
            axios.put(`${this.controller}/${this.rowItem.id}`, this.rowItem).then(response => {
                if(response.data.status === 'Success'){
                    this.closeDialogForm()
                    this.getArticulos()
                }
            })
        },

        addItem(){
            this.dialogForm = true
        },

        editItem(item){
            this.dialogForm = true
            this.isNewItem = false
            this.rowItem = item
        },

        openDialogForm(){
            this.dialogForm = true
        },

        closeDialogForm(){
            this.dialogForm = false
            this.getRowItem()
        },
    }
}
</script>

<style>

</style>
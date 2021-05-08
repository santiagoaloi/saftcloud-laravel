import axios from 'axios'
import { store } from '@/store'
import {mapGetters} from 'vuex'

export default {
    components: {},
    data() {
		return {

            hideheaders: true,
            hideactions: true,
            display_empty_message: false,
            precision: 2,

            /* Dialogs */
            dialogSelected: false,
            dialogFormModal: false,
            dialogViewModal: false,

            isNewItem: false,

            /* From Menus */
            vertical_menu: "",
            tab_item: 0,
            form_menus: [],

            /* Desktop Shortcut */
            desktop: "",
            desktop_access: [
                {
                    username: "",
                    x: 0,
                    y: 0,
                    context_menu_activator: false,
                    loading: false,
                    path: "",
                    controller: "",
                    icon: "",
                    id: Date.now()
                }
            ],

            date: "",

            /* Snackbar */
            snackbar: false,
            is_status: "",
            is_message: "",
            is_icon: "",

            /* Validation */
            validation_errors: false,
            validation_message: "",
            validation_passed: false,

            /* Codeigniter  queries */
            query: [],
            query_save: [],
            query_delete: [],
            query_data: [],
            query_table: [],
            component: "",

            /* log data */
            log_insert: "",
            log_change: "",
            log_remove: "",
            logs: "",
            user: "",

            /* Dinamic Data From CRUDENGINE */
            pageHeader: "",
            primaryIndex: null,
            headers: [],
            rows: [],
            rowItemEdit: [],
            itemSelected: {},
            rowItem: [],
            forms: [],
            rowItemView: [],
            detailItem: [],
            options: [],
            access: {
                is_add: 0,
                is_view: 0,
                is_edit: 0,
                is_remove: 0
            },
            /* END Dinamic Data From CRUDENGINE */
            baseUrl: store.state.baseUrl,
            nodata: 'uploads/images/no-products.png'
        }
    },

    computed: {
        ...mapGetters(['GET_DEFAULT_COMPANY']),

        profile () {
            return store.state.sessionData.userProfile
        },
  
        settings () {
            return store.state.globalConfig.settings
        },
    },

    methods: {
        get_rowItem() {
            axios.get(this.controller).then(response => {
                if (response.data.status == "Success") {
                    this.rowItem = response.data.data.models;
                }
            });
        },

        addItem() {
            this.rowItemReset();
            this.isNewItem = true;
            this.key_id_value = "";
            this.dialogFormModal = true;
        },

        refresh_rows() {
            this.REFRESHloading = true;
            axios.get(this.controller).then(response => {
                if (response.data.status == "Success") {
                    this.rows = response.data.data.rows;
                    this.REFRESHloading = false;
                }
            });
        },

        close() {
            window.getApp.$emit("APP_VALIDATE_FORMS_RESET");
            this.loading = false;
            this.validation_passed = false;
            this.dialogSelected = false;
            this.dialogFormModal = false;
            this.dialogViewModal = false;
            this.get_rowItem();
        },

        viewSelected() {
            this.dialogSelected = true;
        },

        configure () {
            let url = '/secure/manage/config?table=' + this.query_table + '&id=' + this.component
            this.$router.push(url)
        },

        searching (searchinput) {
            this.search = searchinput
        },

        inputFunction (func, params1, params2, params3, params4) {
            if (func != '') {
                this[func](params1, params2, params3, params4)
            }
        },
      
        changeFunction (func, params1, params2, params3, params4) {
            if (func != '') {
                this[func](params1, params2, params3, params4)
            }
        },
      
        dynamic_dropdown_item_add (name, identifier) {
            this.$modal.show(name), (this.drop_down_type = identifier)
        },
      
        getVerticalMenuStatus () {
            axios.post('sximo/components/getVerticalMenuStatus/' + '/' + this.component).then(response => {
                this.vertical_menu = response.data[0].vertical_menu
            })
        },
      
        get_form_menus () {
            this.loading = true
            axios.get('sximo/components/get_form_menus/' + this.component).then(response => {
                this.form_menus = response.data.data
                NProgress.done()
                this.loading = false
              })
        },

        createDesktopShortcut () {
            let post = {
                data: this.desktop_access,
                username: this.profile.uid
            }
            axios.post(this.controller + '/createDesktopShortcut/', post).then(response => {
                if (response.data.status == 'Success') {
                    this.is_icon = 'done'
                    this.is_status = 'teal'
                    this.is_message = ' shortcut added to desktop.'
                    this.snackbar = true
                } else {
                    this.is_status = 'teal'
                    this.is_message = response.data.message
                    this.snackbar = true
                }
            })
        },

        saveCustomView (msg) {
            this.$validator.validateAll().then(result => {
                if (result) {
                    let save = {
                    id: this.component,
                    data: this.pagination
                    }
                    axios.post('sximo/components/saveInfo_custom_view/' + this.component + '/' + this.desktop + '/' + this.pageHeader, save).then(response => {
                        if (response.data.status == 'Success') {
                            if (msg === 'title') {
                                // this.is_message = 'Title updated.'
                            } else {
                                this.is_message = 'Table view setting saved.'
                                this.is_icon = 'done'
                                this.is_status = '#57AEB1'
                                this.snackbar = true
                            }
                        }
                    })
                }
            })
        },
    }


}
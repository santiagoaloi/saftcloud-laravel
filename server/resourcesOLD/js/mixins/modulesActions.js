import { call } from 'vuex-pathify';

export default {
  name: 'modulesActionsMixin',
  methods: {
    ...call('modulesManagement/*'),

    removeModuleWarning(id, method, apiPath) {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : ''} "> Delete Modules? </span>`,
        html: `<span style="color:${this.isDark ? 'lightgrey' : ''} "> This module will be deleted inmediately.</span>`,
        color: 'white',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#EC407A',
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
        width: 600,
      }).then((result) => {
        if (result.value) {
          this.removeModule({ id, method, apiPath });
        }
      });
    },
  },
};

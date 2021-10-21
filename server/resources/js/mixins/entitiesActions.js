import { call } from 'vuex-pathify';

export default {
  name: 'EntitiesActionsMmixin',
  methods: {
    ...call('entitiesManagement/*'),

    removeUserWarning(id, name) {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : ''} "> Delete user </span>`,
        html: `<span style="color:${
          this.isDark ? 'lightgrey' : ''
        } "> Are you sure you want to delete ${name}?</span>`,
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
          this.removeUser(id);
        }
      });
    },

    removeRoleWarning(id, name) {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : ''} "> Delete user </span>`,
        html: `<span style="color:${
          this.isDark ? 'lightgrey' : ''
        } "> Are you sure you want to delete ${name}?</span>`,
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
          this.removeRole(id);
        }
      });
    },
  },
};

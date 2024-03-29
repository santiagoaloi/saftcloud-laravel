import { sync, call, get } from 'vuex-pathify';
import { store } from '@/store';

export default {
  name: 'ModulesGroupsMixin',
  data() {
    return {
      groupBeingRemoved: '',
    };
  },

  computed: {
    ...sync('theme', ['isDark', 'overlay']),
    ...sync('modulesManagement', [
      'allGroups',
      'selectedModuleGroups',
      'selectedModuleGroupsMenu',
      'selectedModuleGroupsMenuTrigger',
      'groupName',
      'groupParent',
      'allModules',
      'dbGroupNames',
      'groupNameBeingRemoved',
    ]),
    ...get('modulesManagement', ['hasSelectedAllGroups', 'hasSelectedSomeGroups', 'countModulesInGroup']),

    formattedGroup() {
      if (this.groupName) return `"${this.groupName}"`;
    },

    icon() {
      if (this.hasSelectedAllGroups) return 'mdi-close-box';
      if (this.hasSelectedSomeGroups) return 'mdi-minus-box';
      return 'mdi-checkbox-blank-outline';
    },
  },

  methods: {
    ...call('modulesManagement/*'),

    dbGroupNamesFiltered(editedGroupName) {
      const result = this.dbGroupNames.filter((g) => g !== editedGroupName);
      return result;
    },

    addGroupDialog() {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : 'black'} "> Create new group </span>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#5469d4',
        customClass: {
          input: `${this.isDark ? 'swalDarkTitle' : ''}`,
          validationMessage: `${this.isDark ? 'swalDarkValidation' : ''}`,
        },
        inputAttributes: {
          maxlength: 20,
          autocapitalize: 'off',
          autocorrect: 'off',
        },
        input: 'text',
        inputPlaceholder: '. . .',
        inputValue: this.groupName,
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
        inputValidator: (value) => {
          if (!value) {
            return 'You need to write a group name';
          }
        },
      }).then((result) => {
        if (result.value) {
          this.groupName = result.value;
          this.selectGroupParentNewGroup();
        } else if (result.dismiss === 'cancel') {
          this.groupName = '';
        }
      });
    },

    selectGroupParentNewGroup() {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : 'black'} "> Select Group Parent </span>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonText: 'Create group',
        cancelButtonText: 'Back',
        confirmButtonColor: '#5469d4',
        customClass: {
          input: `${this.isDark ? 'swalDarkSelect' : ''}`,
        },
        input: 'select',
        inputOptions: ['No Parent', ...this.dbGroupNames],
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
      }).then((result) => {
        if (result.value) {
          this.groupParent = result.value;
          this.saveGroup();
        } else if (result.dismiss === 'cancel') {
          this.addGroupDialog();
        }
      });
    },

    renameGroupDialog(id, name) {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : 'black'} "> Edit group </span>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#5469d4',
        customClass: {
          input: `${this.isDark ? 'swalDarkTitle' : ''}`,
        },
        inputAttributes: {
          maxlength: 20,
          autocapitalize: 'off',
          autocorrect: 'off',
        },
        input: 'text',
        inputValue: name,
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
        inputValidator: (value) => {
          if (!value) {
            return 'You need to write a group name';
          }
        },
      }).then((result) => {
        if (result.value) {
          this.groupName = result.value;
          this.selectGroupParentEditGroup(id, this.groupName);
        }
      });
    },

    selectGroupParentEditGroup(id, name) {
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : 'black'} "> Select Group Parent </span>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonText: 'Save group',
        cancelButtonText: 'Back',
        confirmButtonColor: '#5469d4',
        customClass: {
          input: `${this.isDark ? 'swalDarkSelect' : ''}`,
        },
        input: 'select',
        inputOptions: ['No Parent', ...this.dbGroupNamesFiltered(name, id)],
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
      }).then((result) => {
        if (result.value) {
          const groupParent = Number(result.value);
          this.renameGroup({ id, groupParent });
        } else if (result.dismiss === 'cancel') {
          this.renameGroupDialog(id, name);
        }
      });
    },

    removeGroupWarning(id, name) {
      this.groupBeingRemoved = id;
      this.groupNameBeingRemoved = name;
      this.$swal({
        title: `<span style="color:${this.isDark ? 'lightgrey' : ''} "> Delete ${name} group? </span>`,
        allowOutsideClick: false,
        html: `<span style="color:${
          this.isDark ? 'lightgrey' : ''
        } ">  If no modules are linked to this group, this group will be removed inmediately, otherwise you can choose to remove the associated Modules permanently.  </span>`,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#EC407A',
        backdrop: `${this.isDark ? 'rgba(0, 0, 0, 0.6)' : 'rgba(108, 122, 137, 0.8)'}`,
        background: `${this.isDark ? '#2f3136' : ''}`,
        width: 600,
      }).then((result) => {
        if (result.value) {
          this.removeGroup(id);
        }
      });
    },

    syncGroupInputValue(e) {
      store.set('modulesManagement/groupName', e);
    },
  },
};

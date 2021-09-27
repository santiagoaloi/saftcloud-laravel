<template>
  <div :class="editorStyle">
    <textarea ref="textarea" />
  </div>
</template>

<script>
import { sync } from 'vuex-pathify';
import CodeMirror from 'codemirror';
import 'codemirror/addon/lint/lint.css';
import 'codemirror/lib/codemirror.css';
import 'codemirror/theme/material-darker.css';

import 'codemirror/theme/elegant.css';
import 'codemirror/mode/javascript/javascript';
import 'codemirror/mode/markdown/markdown';
import 'codemirror/addon/lint/lint';
import 'codemirror/addon/lint/json-lint';
import 'codemirror/addon/edit/matchBrackets';
import 'codemirror/addon/hint/show-hint';
import 'codemirror/addon/hint/show-hint.css';
import 'codemirror/addon/hint/sql-hint';
import 'codemirror/mode/sql/sql';

require('script-loader!jsonlint');

export default {
  name: 'Editor',
  props: ['value', 'mode'],
  data() {
    return {
      editor: {},
      tables: {
        users: ['name', 'score', 'birthDate'],
        countries: ['name', 'population', 'size'],
      },
    };
  },
  computed: {
    ...sync('theme', ['isDark']),
    ...sync('componentManagement', ['dbTablesAndColumns']),

    editorStyle() {
      if (this.mode === 'sql') return 'text/x-mariadb';
      if (this.mode === 'json') return 'json-editor';
      if (this.mode === 'markdown') return 'mrkd-editor';
    },

    codeStyle() {
      if (this.mode === 'sql') return 'text/x-mariadb';
      if (this.mode === 'json') return 'application/json';
      if (this.mode === 'markdown') return 'text/x-markdown';
    },
  },
  watch: {
    value(value) {
      const editorValue = this.editor.getValue();
      if (value !== editorValue) {
        this.editor.setValue(this.value);
        setTimeout(() => {
          this.editor.refresh();
        }, 50);
      }
    },
  },

  mounted() {
    this.editor = CodeMirror.fromTextArea(this.$refs.textarea, {
      spellcheck: false,
      autocorrect: false,
      autocapitalize: false,
      lineNumbers: true,
      lineWrapping: true,
      mode: this.codeStyle,
      smartIndent: true,
      autofocus: true,
      showCursorWhenSelecting: true,
      gutters: ['CodeMirror-lint-markers'],
      theme: this.isDark ? 'material-darker' : 'elegant',
      lint: true,
      hintOptions: {
        completeSingle: false,
        tables: { ...this.tables, ...this.dbTablesAndColumns },
      },
    });

    // Show sql hints only when alpha keystrokes are pressed.
    const letters = /^[A-Za-z]+$/;
    this.editor.on('inputRead', (editor, change) => {
      if (change.text[0].match(letters) || change.text[0] === '.') {
        editor.showHint();
      }
    });

    this.editor.on('change', (CodeMirror) => {
      this.$emit('changed', CodeMirror.getValue());
      this.$emit('input', CodeMirror.getValue());
    });

    this.editor.setValue(this.value);
    setTimeout(() => {
      this.editor.refresh();
    }, 50);
  },
  methods: {
    getValue() {
      return this.editor.getValue();
    },
  },
};
</script>

<style>
.text\/x-mariadb {
 height: 100%;
 position: relative;
}

.text\/x-mariadb >>> .CodeMirror {
 height: 100%;
 position: relative;
}

.json-editor >>> .CodeMirror {
 height: 100%;
 min-height: 300px;
}
.json-editor >>> .CodeMirror-scroll {
 height: 100%;
}
.mrkd-editor {
 height: 100%;
}
.mrkd-editor >>> .CodeMirror {
 height: 100%;
 min-height: 300px;
}
.mrkd-editor >>> .CodeMirror-scroll {
 height: 100%;
}

.CodeMirror-hints {
 z-index: 9999 !important;
}

.CodeMirror {
 height: 100%;
 font-size: 19px !important;
}
</style>

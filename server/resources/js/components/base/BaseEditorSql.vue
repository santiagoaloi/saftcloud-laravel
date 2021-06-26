<template>
 <div :class="editorStyle">
  <input ref="textarea" />
 </div>
</template>

<script>
import CodeMirror from "codemirror";

import "codemirror/addon/lint/lint.css";
import "codemirror/addon/lint/lint";
import "codemirror/addon/lint/json-lint";
import "codemirror/addon/edit/matchBrackets";

import "codemirror/addon/hint/show-hint";
import "codemirror/addon/hint/show-hint.css";

import "codemirror/addon/hint/sql-hint";
import "codemirror/mode/sql/sql";

import "codemirror/lib/codemirror.css";
import "codemirror/theme/material.css";
import "codemirror/mode/javascript/javascript";
import "codemirror/mode/markdown/markdown";

require("script-loader!jsonlint");

export default {
 name: "Editor",
 /* eslint-disable vue/require-prop-types */
 props: ["value", "mode"],
 data() {
  return {
   editor: {}
  };
 },
 computed: {
  editorStyle() {
   return this.mode === "text/x-markdown" ? "mrkd-editor" : "json-editor";
  }
 },

 watch: {
  value(value) {
   const editorValue = this.editor.getValue();
   if (value !== editorValue) {
    this.editor.setValue(this.value);
    setTimeout(() => {
     this.editor.refresh();
    }, 1);
   }
  }
 },

 mounted() {
  this.editor = CodeMirror.fromTextArea(this.$refs.textarea, {
   lineNumbers: true,
   matchBrackets: true,
   mode: "text/x-mariadb",
   autofocus: true,
   indentWithTabs: true,
   smartIndent: true,
   gutters: ["CodeMirror-lint-markers"],
   theme: this.mode === "text/x-markdown" ? "default" : "material",
   lint: true,

   hintOptions: {
    completeSingle: false,
    tables: {
     users: ["name", "score", "birthDate"],
     countries: ["name", "population", "size"]
    }
   }
  });

  this.editor.setValue(this.value);
  setTimeout(() => {
   this.editor.refresh();
  }, 1);

  this.editor.on("change", cm => {
   this.$emit("changed", cm.getValue());
   this.$emit("input", cm.getValue());
  });

  var letters = /^[A-Za-z]+$/;
  this.editor.on("inputRead", function(editor, change) {
   if (change.text[0].match(letters)) {
    editor.showHint();
   }
  });
 },
 methods: {
  getValue() {
   return this.editor.getValue();
  }
 }
};
</script>
<style>
.json-editor {
 height: 100%;
 font-size: 14px;
 position: relative;
}

.json-editor >>> .CodeMirror {
 /* height: auto; */
 height: 100%;
}

.json-editor >>> .CodeMirror-scroll {
 height: 99%;
}

.mrkd-editor {
 height: auto;
 font-size: 14px;
}

.mrkd-editor >>> .CodeMirror {
 height: auto;
 min-height: 300px;
}

.mrkd-editor >>> .CodeMirror-scroll {
 min-height: 300px;
}
</style>

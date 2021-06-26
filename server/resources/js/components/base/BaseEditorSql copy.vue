<template>
 <textarea ref="mycode" v-model="value"> </textarea>
</template>
<script>
import CodeMirror from "codemirror";
import "codemirror/theme/material.css";
import "codemirror/lib/codemirror.css";
import "codemirror/addon/edit/matchBrackets";

import "codemirror/addon/hint/show-hint";
import "codemirror/addon/hint/show-hint.css";

import "codemirror/addon/hint/sql-hint";
import "codemirror/mode/sql/sql";

export default {
 name: "SqlEditor",
 data() {
  return {
   editor: {}
  };
 },
 props: {
  value: {
   type: String,
   default: ""
  },
  sqlStyle: {
   type: String,
   default: "default"
  },
  readOnly: {
   type: [Boolean, String]
  }
 },

 watch: {
  value(value) {
   const editorValue = this.editor.getValue();
   if (value !== editorValue) {
    this.editor.setValue(this.value);
    this.$emit("input", this.editor.getValue());

    setTimeout(() => {
     this.editor.refresh();
    }, 1);
   }
  }
 },

 mounted() {
  this.editor = CodeMirror.fromTextArea(this.$refs.mycode, {
   mode: "text/x-mariadb",
   lineNumbers: true,
   matchBrackets: true,
   theme: "material",

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

  var letters = /^[A-Za-z]+$/;

  this.editor.on("inputRead", function(editor, change) {
   if (change.text[0].match(letters)) {
    editor.showHint();
   }
  });
 },
 methods: {}
};
</script>
<style>
.CodeMirror-hints {
 z-index: 9999 !important;
}

.CodeMirror {
 height: 100%;
 font-size: 16px !important;
}
</style>

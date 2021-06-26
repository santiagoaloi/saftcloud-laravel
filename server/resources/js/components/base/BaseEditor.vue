<template>
 <div :class="editorStyle">
  <textarea ref="textarea" />
 </div>
</template>

<script>
import { sync } from "vuex-pathify";
import CodeMirror from "codemirror";
import "codemirror/addon/lint/lint.css";
import "codemirror/lib/codemirror.css";
import "codemirror/theme/material-palenight.css";
import "codemirror/theme/eclipse.css";
import "codemirror/theme/dracula.css";
import "codemirror/theme/base16-light.css";

import "codemirror/mode/javascript/javascript";
import "codemirror/mode/markdown/markdown";
import "codemirror/addon/lint/lint";
import "codemirror/addon/lint/json-lint";

require("script-loader!jsonlint");

export default {
 name: "Editor",
 props: ["value", "mode"],

 data() {
  return {
   editor: {}
  };
 },
 computed: {
  ...sync("theme", ["isDark"]),

  editorStyle() {
   if (this.mode === "sql") return "text/x-mariadb";
   if (this.mode === "json") return "json-editor";
   if (this.mode === "markdown") return "mrkd-editor";
  },

  codeStyle() {
   if (this.mode === "sql") return "text/x-mariadb";
   if (this.mode === "json") return "application/json";
   if (this.mode === "markdown") return "text/x-markdown";
  }
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
  }
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
   gutters: ["CodeMirror-lint-markers"],
   theme: this.isDark ? "material-palenight" : "base16-light",
   lint: true,
   hintOptions: {
    completeSingle: false,
    tables: {
     users: ["name", "score", "birthDate"],
     countries: ["name", "population", "size"]
    }
   }
  });

  //Show sql hints only when letters are pressed.
  var letters = /^[A-Za-z]+$/;
  this.editor.on("inputRead", function(editor, change) {
   if (change.text[0].match(letters)) {
    editor.showHint();
   }
  });

  this.editor.on("change", CodeMirror => {
   this.$emit("changed", CodeMirror.getValue());
   this.$emit("input", CodeMirror.getValue());
  });

  this.editor.setValue(this.value);
  setTimeout(() => {
   this.editor.refresh();
  }, 50);
 },
 methods: {
  getValue() {
   return this.editor.getValue();
  }
 }
};
</script>

<style scoped>
.text\/x-mariadb {
 height: 100%;
 font-size: 22px !important;
 position: relative;
}

.text\/x-mariadb >>> .CodeMirror {
 height: 100%;
 font-size: 22px !important;
 position: relative;
}

.json-editor {
 height: 100%;
 font-size: 22px;
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
 font-size: 22px;
}
.mrkd-editor >>> .CodeMirror {
 height: 100%;
 min-height: 300px;
}
.mrkd-editor >>> .CodeMirror-scroll {
 height: 100%;
}
</style>

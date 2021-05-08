import { mapActions } from "vuex";

export default {
  props: {
    editor: {
      default: null,
      type: Object,
    },
    value: {
      default: "",
      type: String,
    },
  },

  watch: {
    editor: {
      immediate: true,
      handler(editor) {
        if (!editor || !editor.element) return;

        this.editor.setContent(this.value);
        this.editor.on("update", ({ getHTML }) => {
          this.$emit("input", getHTML());

          const text = getHTML();
          this.setElementTextAdvanced({ text });
        });

        this.$nextTick(() => {
          this.$el.appendChild(editor.element.firstChild);
          editor.setParentComponent(this);
        });
      },
    },
  },

  methods: {
    ...mapActions(["setElementTextAdvanced"]),
  },

  render(createElement) {
    return createElement("div");
  },

  beforeDestroy() {
    this.editor.element = this.$el;
  },
};

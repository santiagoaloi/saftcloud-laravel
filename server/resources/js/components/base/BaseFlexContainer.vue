<template>
  <div class="flex-container" :style="`width: ${width};top: ${top}px`" v-on="$listeners">
    <div class="flex-wrapper">
      <div v-show="$slots.top" class="content mx-0" style="background: rgba(34, 37, 48, 0.9)">
        <slot name="top"> </slot>
      </div>

      <div id="flex-content" v-resize="calculateHeight" class="flex-scrollable-content">
        <slot :height="contentHeight"> </slot>
      </div>

      <div v-show="$slots.footer">
        <slot name="footer"> </slot>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'FlexContainer',

    props: {
      width: {
        type: [String],
        default: () => '100%',
      },
      top: {
        type: [String, Number],
        default: () => 0,
      },
    },
    data() {
      return {
        contentHeight: '',
      };
    },

    methods: {
      calculateHeight() {
        setTimeout(() => {
          this.contentHeight = parseFloat(
            getComputedStyle(document.getElementById('flex-content')).height,
          );
        }, 100);
      },
    },
  };
</script>
<style scoped>
  .flex-container {
    /* give the outermost container a predefined size */
    position: absolute;
    /* top: 0; */
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    /* width: 100%; */
  }

  .flex-wrapper {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    /* for Firefox */
    min-height: 0;
  }

  .content {
    margin-left: 10px;
    margin-right: 10px;
  }

  .flex-scrollable-content {
    flex-grow: 1;
    overflow: auto;
    overflow: overlay;
    /* for Firefox */
  }
</style>

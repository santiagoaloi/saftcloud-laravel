<template>
  <div class="flex-container" :style="`top: ${top}px;width: ${width}px`">
    <div :style="`width: ${width}px`" class="flex-wrapper">
      <div v-show="$slots.top" class="mx-0" style="background: rgba(34, 37, 48, 0.9)">
        <slot name="top"> </slot>
      </div>

      <div class="flex-scrollable-content">
        <slot> </slot>
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
  };
</script>
<style scoped>
  .flex-container {
    /* give the outermost container a predefined size */
    position: absolute;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    width: 100%;
    z-index: 1;
  }

  .flex-wrapper {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    /* for Firefox */
    min-height: 0;
  }

  .content {
    display: flex;
  }

  .flex-scrollable-content {
    flex-grow: 1;
    overflow: auto;
    overflow: overlay;
  }
</style>

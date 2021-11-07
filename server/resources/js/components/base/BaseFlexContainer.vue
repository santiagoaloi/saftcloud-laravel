<template functional>
  <div class="flex-container">
    <div class="flex-wrapper">
      <div v-show="$slots.top" class="content mx-0" style="background: rgba(34, 37, 48, 0.9)">
        <slot name="top"> </slot>
      </div>

      <div class="flex-scrollable-content content dottedBackground">
        <slot> </slot>
      </div>

      <div v-show="$slots.footer" class="content">
        <slot name="footer"> </slot>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'FlexContainer',
  };
</script>
<style scoped>
  .flex-container {
    /* give the outermost container a predefined size */
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    width: 100%;
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
    /* for Firefox */
    min-height: 0;
  }
</style>

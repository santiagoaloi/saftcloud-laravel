<template>
  <div class="flex-container">
    <div class="flex-wrapper">
      <div v-if="$slots.top" class="content">
        <slot name="top"> </slot>
      </div>

      <div v-if="$slots.main" class="flex-scrollable-content content dottedBackground">
        <slot name="main"> </slot>
      </div>

      <div v-if="$slots.footer" class="content">
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
    margin: 10px;
  }

  .flex-scrollable-content {
    flex-grow: 1;

    overflow: auto;

    /* for Firefox */
    min-height: 0;
  }
</style>

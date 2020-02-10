<template>
  <i :class="[`tiptap-${name}`]"></i>
</template>

<script>
export default {
  name: 'Icon',
  props: {
    name: String
  }
}
</script>

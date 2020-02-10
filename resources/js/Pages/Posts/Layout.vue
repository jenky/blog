<template>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <h3 class="page-title mb-5">Posts</h3>
      <Sidebar />
    </div>
    <div class="col-md-9">
        <slot />
    </div>
  </div>
</div>
</template>

<script>
import Sidebar from './Sidebar'

export default {
  name: 'PostLayout',
  components: {
    Sidebar,
  }
}
</script>

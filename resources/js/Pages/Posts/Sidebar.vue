<template>
<div>
  <div class="list-group list-group-transparent mb-0">
    <!-- <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">
      <span class="icon mr-3"><i class="fe fe-inbox"></i></span>Inbox <span class="ml-auto badge badge-primary">14</span>
    </a> -->
    <inertia-link :href="$route('posts.index')"
      class="list-group-item list-group-item-action d-flex align-items-center"
      :class="{ active: $router.current('posts.index') && this.$page.published === null }">
      <span class="icon mr-3"><i class="fe fe-file-text"></i></span>All Posts
    </inertia-link>
    <inertia-link :href="$route('posts.index', { published: 1 })"
      class="list-group-item list-group-item-action d-flex align-items-center"
      :class="{ active: $router.current('posts.index') && this.$page.published == 1 }">
      <span class="icon mr-3"><i class="fe fe-send"></i></span>Published Posts
    </inertia-link>
    <inertia-link :href="$route('posts.index', { published: 0 })"
      class="list-group-item list-group-item-action d-flex align-items-center"
      :class="{ active: $router.current('posts.index') && this.$page.published == 0 }">
      <span class="icon mr-3"><i class="fe fe-file"></i></span>Unpublished Posts
    </inertia-link>
    <!-- <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
      <span class="icon mr-3"><i class="fe fe-alert-circle"></i></span>Important <span class="ml-auto badge badge-secondary">3</span>
    </a> -->
  </div>
  <div class="mt-6" v-if="!$router.current('posts.create')">
    <inertia-link :href="$route('posts.create')" class="btn btn-primary btn-block">Compose new Post</inertia-link>
  </div>
</div>
</template>

<script>
export default {
  name: 'PostSidebar',
}
</script>

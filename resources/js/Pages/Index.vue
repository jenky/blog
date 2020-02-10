<template>
<div class="container">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Home</h1>
      <div class="page-options d-flex">
        <div class="input-icon ml-2">
          <span class="input-icon-addon">
            <i class="fe fe-search"></i>
          </span>
          <input v-model="keyword"
            @keyup.enter="search"
            @focus="$event.target.select()"
            type="text"
            class="form-control w-10"
            placeholder="Search...">
          <span class="input-icon-addon">
            <a @click.prevent="keyword = ''"
              v-show="keyword.length"
              class="btn btn-sm btn-default"
              style="pointer-events: auto;">
              <i class="fe fe-delete"></i>
            </a>
          </span>
        </div>
      </div>
    </div>

    <div v-if="posts.data.length"
      class="row row-cards row-deck">
      <div v-for="post in posts.data"
        :key="post.id"
        class="col-lg-4">
        <div class="card">
          <div class="card-body d-flex flex-column">
            <h4><inertia-link :href="$route('posts.show', post)">{{ post.title }}</inertia-link></h4>
            <div class="text-muted" v-html="truncate(post.content, 30)"></div>
            <div class="d-flex align-items-center pt-5 mt-auto">
              <div class="avatar avatar-md mr-3" :style="{ backgroundImage: `url('${post.user.avatar_url}')` }"></div>
              <div>
                <a href="#" class="text-default">{{ post.user.name }}</a>
                <small class="d-block text-muted">{{ $date(post.published_at).fromNow() }}</small>
              </div>
              <div class="ml-auto text-muted">
                <inertia-link :href="$route('posts.show', post)"
                  class="icon d-none d-md-inline-block ml-3">
                  <i class="fe fe-eyes mr-1"></i>
                </inertia-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center">
      <h3 class="text-muted-dark font-italic">Nothing to see here</h3>
      <h5 class="text-muted">
        Perhaps you may want to <inertia-link class="text-primary text-decoration-none" :href="$route('posts.create')">create a new post</inertia-link>?
      </h5>
    </div>
  </div>
</div>
</template>

<script>
import Layout from '../Shared/Layout'

export default {
  name: 'PostIndex',
  layout: Layout,
  props: {
    posts: Object
  },
  watch: {
    keyword (value) {
      if (!value.length) {
        this.$inertia.visit(this.$route('index'), {
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  },
  data () {
    return {
      keyword: ''
    }
  },
  methods: {
    truncate (input, length = 20) {
      return input.length > length ? `${input.substring(0, length)}...` : input
    },
    search () {
      if (this.keyword.length > 2) {
        this.$inertia.visit(this.$route('index'), {
          data: {
            search: this.keyword
          },
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  }
}
</script>

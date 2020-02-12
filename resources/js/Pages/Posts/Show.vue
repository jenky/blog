<template>
<div class="container">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">
        {{ post.title }}
      </h1>
    </div>

    <div class="row">
      <div class="col-lg-3 order-lg-1 mb-4">
        <!-- <div class="card">
          <div class="card-body">

          </div>
        </div> -->
        <div class="media">
          <span class="avatar avatar-xl mr-5" :style="{ backgroundImage: `url('${post.user.avatar_url}')` }"></span>
          <div class="media-body">
            <h4 class="m-0">{{ post.user.name }}</h4>
            <p class="text-muted mb-0">{{ post.user.is_admin ? 'Administrator' : 'Writer' }}</p>
            <p class="text-muted-dark font-italic" v-if="post.published_at">
              {{ post.scheduled ? 'Schedule to publish' : 'Published' }} at {{ $date(post.published_at).format('llll') }}
            </p>
          </div>
        </div>

        <div class="d-none d-lg-block mt-6">
          <inertia-link :href="$route('posts.edit', post)"
            v-if="$page.auth.can.post.write"
            class="text-muted text-decoration-none">
            <i class="fe fe-edit"></i>
            Edit this post
          </inertia-link>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <div class="text-wrap p-lg-6" v-html="post.content"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Layout from '../../Shared/Layout'

export default {
  name: 'PostShow',
  layout: Layout,
  props: {
    post: Object
  }
}
</script>

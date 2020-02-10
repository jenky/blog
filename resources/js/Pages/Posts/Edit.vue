<template>
<PostLayout>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Compose new post</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="form-group">
          <div class="row align-items-center">
            <label class="col-sm-2">Title:</label>
            <div class="col-sm-10">
              <input type="text"
                :class="['form-control', { 'is-invalid': $page.errors.title }]"
                v-model="form.title">
              <span v-if="$page.errors.title"
                class="invalid-feedback" role="alert">
                {{ $page.errors.title[0] }}
              </span>
            </div>
          </div>
        </div>
        <Editor v-model="form.content" />
        <div class="btn-list mt-4 text-right">
          <button type="submit" class="btn btn-primary btn-space">Save</button>
        </div>
      </form>
    </div>
  </div>
</PostLayout>
</template>

<script>
import Editor from '../../Shared/Editor'
import Layout from '../../Shared/Layout'
import PostLayout from './Layout'

export default {
  name: 'PostEdit',
  layout: Layout,
  props: ['post'],
  components: {
    PostLayout,
    Editor
  },
  metaInfo () {
    return {
      title: this.post ? `Edit post ${this.post.title}` : 'Create new post'
    }
  },
  data () {
    return {
      form: {
        title: this.post ? this.post.title : '',
        content: this.post ? this.post.content : '',
      }
    }
  },
  methods: {
    submit () {
      if ((this.post && this.post.id)) {
        this.$inertia.put(this.$route('posts.update', this.post), this.form)
      } else {
        this.$inertia.post(this.$route('posts.store'), this.form)
      }
    }
  }
}
</script>

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
        <div v-if="!post.published" class="form-group">
          <div class="row align-items-center">
            <div class="offset-sm-2 col-sm-10">
              <div class="custom-switches-stacked">
                <label class="custom-switch pl-0">
                  <input type="radio"
                    v-model="publishMode"
                    value="now"
                    class="custom-switch-input">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Publish this post now?</span>
                </label>
                <label class="custom-switch pl-0">
                  <input type="radio"
                    v-model="publishMode"
                    value="schedule"
                    class="custom-switch-input">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Schedule this post at</span>
                </label>
              </div>
              <div v-show="publishMode === 'schedule'">
                <flat-pickr
                  v-model="publishedDate"
                  class="form-control"
                  :config="dateConfig" />
              </div>
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
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import Editor from '../../Shared/Editor'
import Layout from '../../Shared/Layout'
import PostLayout from './Layout'

export default {
  name: 'PostEdit',
  layout: Layout,
  props: ['post'],
  components: {
    PostLayout,
    Editor,
    flatPickr
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
      },
      publishMode: (this.post && this.post.scheduled) ? 'schedule' : 'now',
      publishedDate: (this.post && this.post.scheduled)
        ? this.$date(this.post.published_at).toDate()
        : null,
      dateConfig: {
        enableTime: true,
        enableSeconds: true,
        minDate: this.$date().add(1, 'day').startOf('day').toDate(),
        time_24hr: true
      }
    }
  },
  methods: {
    submit () {
      const data = this.form

      if (this.publishMode === 'now') {
        data.publish = 1
      } else if (this.publishMode === 'schedule') {
        data.schedule = this.publishedDate
      }

      if ((this.post && this.post.id)) {
        this.$inertia.put(this.$route('posts.update', this.post), data)
      } else {
        this.$inertia.post(this.$route('posts.store'), data)
      }
    }
  }
}
</script>

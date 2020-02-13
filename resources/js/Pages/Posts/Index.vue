<template>
<PostLayout>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Your posts</h3>
      <div class="card-options">
        <form @submit.prevent="search">
          <div class="input-group">
            <input type="text"
              class="form-control form-control-sm"
              placeholder="Search something..."
              @keyup.enter="search"
              @focus="$event.target.select()"
              v-model="keyword">
            <span class="input-group-btn ml-2">
              <button class="btn btn-sm btn-default" type="submit">
                <span class="fe fe-search"></span>
              </button>
            </span>
          </div>
        </form>
        <label v-if="$page.auth.user.is_admin"
          class="custom-switch">
          <input type="checkbox"
            class="custom-switch-input"
            :true-value="1"
            :false-value="0"
            v-model="sudo">
          <span v-b-popover.hover.bottom="'Sudo mode allows admin to view all posts made by other writers.'"
            class="custom-switch-indicator"
            title="Sudo mode"></span>
        </label>
      </div>
    </div>
    <div class="card-body">
      <div v-if="posts.data.length" class="table-responsive">
        <table class="table card-table table-striped table-vcenter">
          <thead>
            <tr>
              <th v-if="$page.auth.user.is_admin && sudo">User</th>
              <th>Title</th>
              <th>Date</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data"
              :key="post.id">
              <td v-if="$page.auth.user.is_admin  && sudo">{{ post.user.name }}</td>
              <td>
                <inertia-link
                  :href="$route('posts.show', post)"
                  class="text-decoration-none">
                  <i class="fe fe-view"></i>
                  {{ post.title }}
                </inertia-link>
              </td>
              <td class="text-nowrap">
                <span v-b-tooltip.hover
                  :title="$date(post.created_at).format('LLLL')">
                  {{ $date(post.created_at).format('L LT') }}
                </span>
              </td>
              <td>
                <a @click.prevent="publish(post)"
                  v-if="!post.published"
                  v-b-tooltip.hover
                  title="Publish post"
                  class="icon mx-1"><i class="fe fe-eye"></i>
                </a>
                <a @click.prevent="unpublish(post)"
                  v-if="post.published && $page.auth.user.is_admin"
                  v-b-tooltip.hover
                  title="Unpublish post"
                  class="icon mx-1"><i class="fe fe-eye-off"></i>
                </a>
                <inertia-link
                  :href="$route('posts.edit', post)"
                  v-b-tooltip.hover
                  title="Edit post"
                  class="icon mx-1">
                  <i class="fe fe-edit"></i>
                </inertia-link>
                <a @click.prevent="destroy(post)"
                  v-b-tooltip.hover
                  title="Delete post"
                  class="icon mx-1"><i class="fe fe-trash"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center">
        <h5>There are no posts to display.</h5>
      </div>
    </div>
  </div>
</PostLayout>
</template>

<script>
import Layout from '../../Shared/Layout'
import PostLayout from './Layout'

export default {
  name: 'PostIndex',
  layout: Layout,
  props: {
    posts: Object,
    published: [String, Number]
  },
  components: {
    PostLayout
  },
  metaInfo: {
    title: 'All Posts'
  },
  data () {
    return {
      keyword: '',
      sudo: parseInt(this.$cookies.get('sudo')) || 0
    }
  },
  watch: {
    sudo (value) {
      this.$cookies.set('sudo', value)
      this.$inertia.reload({
        preserveState: true,
        preserveScroll: true,
      })
    }
  },
  methods: {
    search () {
      if (this.keyword.length <= 2) {
        return
      }

      this.$inertia.visit(this.$route('posts.index'), {
        data: {
          search: this.keyword,
          published: this.published
        },
        preserveState: true,
        preserveScroll: true,
      })
    },
    destroy (post) {
      if (confirm('Do you want to delete this post?')) {
        this.$inertia.delete(this.$route('posts.destroy', post), {
          preserveState: true,
          preserveScroll: true,
        })
      }
    },
    publish (post) {
      if (post.published) {
        return
      }

      if (confirm('Do you want to publish this post?')) {
        this.$inertia.put(this.$route('posts.update', post), { publish: 1 }, {
          preserveState: true,
          preserveScroll: true,
        })
      }
    },
    unpublish (post) {
      if (!post.published || !this.$page.auth.user.is_admin) {
        return
      }

      if (confirm('Do you want to unpublish this post?')) {
        this.$inertia.put(this.$route('posts.update', post), { unpublish: 1 }, {
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  }
}
</script>

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
      </div>
    </div>
    <div class="card-body">
      <div v-if="posts.data.length" class="table-responsive">
        <table class="table card-table table-striped table-vcenter">
          <thead>
            <tr>
              <!-- <th v-if="$page.auth.user.is_admin" colspan="2">User</th> -->
              <th>Title</th>
              <th>Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data"
              :key="post.id">
              <!-- <td v-if="$page.auth.user.is_admin"><span class="avatar"></span></td>
              <td v-if="$page.auth.user.is_admin">{{ post.user.name }}</td> -->
              <td>
                <inertia-link
                  :href="$route('posts.show', post)"
                  class="text-decoration-none">
                  <i class="fe fe-view"></i>
                  {{ post.title }}
                </inertia-link>
              </td>
              <td class="text-nowrap">{{ post.created_at }}</td>
              <td>
                <a @click.prevent="publish(post)"
                  v-if="!post.published"
                  v-b-tooltip.hover
                  title="Publish post"
                  class="icon"><i class="fe fe-eye"></i>
                </a>
                <inertia-link
                  :href="$route('posts.edit', post)"
                  v-b-tooltip.hover
                  title="Edit post"
                  class="icon">
                  <i class="fe fe-edit"></i>
                </inertia-link>
                <a @click.prevent="destroy(post)"
                  v-b-tooltip.hover
                  title="Delete post"
                  class="icon"><i class="fe fe-trash"></i>
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
      keyword: ''
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
      if (confirm('Do you want to publish this post?')) {
        this.$inertia.put(this.$route('posts.update', post), { publish: 1 }, {
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  }
}
</script>

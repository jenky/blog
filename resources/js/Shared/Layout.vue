<template>
<div class="page">
  <div class="flex-fill">
    <div class="header py-4">
      <div class="container">
        <div class="d-flex">
          <inertia-link class="header-brand" :href="$route('index')">
            <img src="../../images/logo.svg" class="header-brand-img" alt="logo">
          </inertia-link>
          <div class="d-flex order-lg-2 ml-auto">
            <div class="nav-item d-none d-md-flex">
              <inertia-link v-if="$page.auth.user"
                :href="$route('posts.create')"
                class="btn btn-sm btn-outline-primary">
                New post
              </inertia-link>
              <a v-else
                :href="$route('login')"
                class="btn btn-sm btn-outline-primary">
                Login
              </a>
            </div>
            <div v-if="$page.auth.user"
              class="dropdown">
              <!-- <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                <span class="avatar" :style="{ backgroundImage: `url('${$page.auth.user.avatar_url}')` }"></span>
                <span class="ml-2 d-none d-lg-block">
                  <span class="text-default">{{ $page.auth.user.name }}</span>
                  <small class="text-muted d-block mt-1">{{ $page.auth.user.is_admin ? 'Administrator' : 'Writer' }}</small>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <a class="dropdown-item" href="#">
                  <i class="dropdown-icon fe fe-user"></i> Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="dropdown-icon fe fe-settings"></i> Settings
                </a>
                <a class="dropdown-item" href="#">
                  <span class="float-right"><span class="badge badge-primary">6</span></span>
                  <i class="dropdown-icon fe fe-mail"></i> Inbox
                </a>
                <a class="dropdown-item" href="#">
                  <i class="dropdown-icon fe fe-send"></i> Message
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                </a>
                <a class="dropdown-item" href="#">
                  <i class="dropdown-icon fe fe-log-out"></i> Sign out
                </a>
              </div> -->
              <b-dropdown
                toggle-tag="a"
                variant="link"
                toggle-class="nav-link pr-0 leading-none"
                no-caret
                right
                menu-class="dropdown-menu-right dropdown-menu-arrow">
                  <template #button-content>
                    <span class="avatar" :style="{ backgroundImage: `url('${$page.auth.user.avatar_url}')` }"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{ $page.auth.user.name }}</span>
                      <small class="text-muted d-block mt-1">{{ $page.auth.user.is_admin ? 'Administrator' : 'Writer' }}</small>
                    </span>
                  </template>

                  <li>
                    <inertia-link
                      class="dropdown-item"
                      :href="$route('posts.index')">
                      <i class="dropdown-icon fe fe-file-text"></i> Posts
                    </inertia-link>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                  </li>
                  <li>
                    <inertia-link
                      class="dropdown-item"
                      :href="$route('logout')"
                      method="post">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </inertia-link>
                  </li>
              </b-dropdown>
            </div>
          </div>
          <!-- <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
            <span class="header-toggler-icon"></span>
          </a> -->
        </div>
      </div>
    </div>
    <!-- <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3 ml-auto">
            <form class="input-icon my-3 my-lg-0">
              <input type="search" class="form-control header-search" placeholder="Search" tabindex="1">
              <div class="input-icon-addon">
                <i class="fe fe-search"></i>
              </div>
            </form>
          </div>
          <div class="col-lg order-lg-first">
            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
              <li class="nav-item">
                <inertia-link href="/" class="nav-link"><i class="fe fe-home"></i> Home</inertia-link>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Interface</a>
                <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="./cards.html" class="dropdown-item ">Cards design</a>
                  <a href="./charts.html" class="dropdown-item ">Charts</a>
                  <a href="./pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-calendar"></i> Components</a>
                <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="./maps.html" class="dropdown-item ">Maps</a>
                  <a href="./icons.html" class="dropdown-item ">Icons</a>
                  <a href="./store.html" class="dropdown-item ">Store</a>
                  <a href="./blog.html" class="dropdown-item ">Blog</a>
                  <a href="./carousel.html" class="dropdown-item ">Carousel</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link active" data-toggle="dropdown"><i class="fe fe-file"></i> Pages</a>
                <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="./profile.html" class="dropdown-item ">Profile</a>
                  <a href="./login.html" class="dropdown-item ">Login</a>
                  <a href="./register.html" class="dropdown-item ">Register</a>
                  <a href="./forgot-password.html" class="dropdown-item ">Forgot password</a>
                  <a href="./400.html" class="dropdown-item ">400 error</a>
                  <a href="./401.html" class="dropdown-item ">401 error</a>
                  <a href="./403.html" class="dropdown-item ">403 error</a>
                  <a href="./404.html" class="dropdown-item ">404 error</a>
                  <a href="./500.html" class="dropdown-item ">500 error</a>
                  <a href="./503.html" class="dropdown-item ">503 error</a>
                  <a href="./email.html" class="dropdown-item ">Email</a>
                  <a href="./empty.html" class="dropdown-item active">Empty page</a>
                  <a href="./rtl.html" class="dropdown-item ">RTL mode</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="./form-elements.html" class="nav-link"><i class="fe fe-check-square"></i> Forms</a>
              </li>
              <li class="nav-item">
                <a href="./gallery.html" class="nav-link"><i class="fe fe-image"></i> Gallery</a>
              </li>
              <li class="nav-item">
                <a href="./docs/index.html" class="nav-link"><i class="fe fe-file-text"></i> Documentation</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div> -->
    <div class="my-3 my-md-5">
      <slot />
    </div>
  </div>
  <!-- <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-6 col-md-3">
              <ul class="list-unstyled mb-0">
                <li><a href="#">First link</a></li>
                <li><a href="#">Second link</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-3">
              <ul class="list-unstyled mb-0">
                <li><a href="#">Third link</a></li>
                <li><a href="#">Fourth link</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-3">
              <ul class="list-unstyled mb-0">
                <li><a href="#">Fifth link</a></li>
                <li><a href="#">Sixth link</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-3">
              <ul class="list-unstyled mb-0">
                <li><a href="#">Other link</a></li>
                <li><a href="#">Last link</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          Premium and Open Source dashboard template with responsive and high quality UI. For Free!
        </div>
      </div>
    </div>
  </div> -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center flex-row-reverse">
        <div class="col-auto ml-lg-auto">
          <div class="row align-items-center">
            <div class="col-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item"><a href="https://github.com/jenky/blog">Documentation</a></li>
              </ul>
            </div>
            <div class="col-auto">
              <a href="https://github.com/jenky/blog" target="_blank" class="btn btn-outline-primary btn-sm">Source code</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
          <span class="font-weight-bold text-primary"><i class="fe fe-code"></i></span> with <span class="font-weight-bold text-danger"><i class="fe fe-heart"></i></span> by <a href="https://github.com/jenky" target="_blank">Lynh</a>.
          <a href="https://preview.tabler.io" target="_blank">Tabler</a> theme by <a href="https://codecalm.net" target="_blank">codecalm.net</a>
        </div>
      </div>
    </div>
  </footer>
</div>
</template>

<script>
export default {
  name: 'Layout',
  metaInfo () {
    return {
      title: 'Home',
      titleTemplate: `%s | ${this.$page.app.name}`
    }
  }
}
</script>

<template>
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button
      id="sidebarToggleTop"
      class="btn btn-link d-md-none rounded-circle mr-3"
    >
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown no-arrow">
        <a
          class="nav-link dropdown-toggle"
          href="#"
          id="userDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            {{  me.name }}
          </span>
          <img
            class="img-profile rounded-circle"
            :src="me.profile_photo_url"
          >
        </a>
        <div
          class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
          aria-labelledby="userDropdown"
        >
          <a
            class="dropdown-item"
            target="_blank"
            :href="route('profile.show')"
          >
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <!-- <a
            class="dropdown-item"
            href="#"
          >
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a> -->
          <!-- <a
            class="dropdown-item"
            href="#"
          >
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
          </a> -->
          <div class="dropdown-divider"></div>
          <a
            class="dropdown-item"
            href="/logout"
          >
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>

    </ul>

  </nav>
</template>

<script>
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
import { logout } from "../../Api/me";
export default {
  name: "LayoutHeaderComponent",
  setup() {
    const me = ref({});
    const query = useQuery(gql`
      query {
        me {
          name
          profile_photo_url
        }
      }
    `);
    query.onResult(function (result) {
      me.value = result.data.me;
    });
    return {
      me,
      logout: logout,
    };
  },
};
</script>

<style scoped>
</style>

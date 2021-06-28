<template>
  <div id="wrapper">

    <!-- Sidebar -->
    <layout-navbar-component></layout-navbar-component>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div
      id="content-wrapper"
      class="d-flex flex-column"
    >

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <layout-header-component></layout-header-component>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
              <slot name="title"></slot>
            </h1>
            <div class="d-flex align-items-center justify-content-between space-x-2">
              <slot name="actions"></slot>
            </div>

          </div>
          <div class='card  shadow h-100'>
            <slot></slot>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
</template>

<script>
// import JetApplicationMark from '@/Jetstream/ApplicationMark'
// import JetBanner from '@/Jetstream/Banner'
// import JetDropdown from '@/Jetstream/Dropdown'
// import JetDropdownLink from '@/Jetstream/DropdownLink'
// import JetNavLink from '@/Jetstream/NavLink'
// import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

import LayoutNavbarComponent from "../Components/Layout/LayoutNavbarComponent";
import LayoutHeaderComponent from "../Components/Layout/LayoutHeaderComponent";
export default {
  components: { LayoutHeaderComponent, LayoutNavbarComponent },
  data() {
    const item = {
      date: "2016-05-02",
      name: "Tom",
      address: "No. 189, Grove St, Los Angeles",
    };
    return {
      tableData: Array(20).fill(item),
    };
  },
  // components: {
  //     JetApplicationMark,
  //     JetBanner,
  //     JetDropdown,
  //     JetDropdownLink,
  //     JetNavLink,
  //     JetResponsiveNavLink,
  // },
  //
  // data() {
  //     return {
  //         showingNavigationDropdown: false,
  //     }
  // },
  //
  // methods: {
  //     switchToTeam(team) {
  //         this.$inertia.put(route('current-team.update'), {
  //             'team_id': team.id
  //         }, {
  //             preserveState: false
  //         })
  //     },
  //
  //     logout() {
  //         this.$inertia.post(route('logout'));
  //     },
  // }
};
</script>

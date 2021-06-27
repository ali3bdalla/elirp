<template>
  <ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
  >

    <!-- Sidebar - Brand -->
    <a
      class="sidebar-brand d-flex align-items-center justify-content-center"
      href="index.html"
    >
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a
        class="nav-link"
        href="index.html"
      >
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseTwo"
        aria-expanded="true"
        aria-controls="collapseTwo"
      >
        <i class="fas fa-warehouse"></i>
        <span>Inventory</span>
      </a>
      <div
        id="collapseTwo"
        class="collapse"
        aria-labelledby="headingTwo"
        data-parent="#accordionSidebar"
      >
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Items:</h6> -->
          <a
            class="collapse-item"
            :href="route('items.index')"
          >Items ({{ totalItems }})</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Warehouses</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Transactions</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#purchasesCollapse"
        aria-expanded="true"
        aria-controls="purchasesCollapse"
      >
        <i class="fas fa-store-alt"></i>
        <span>Purchases</span>
      </a>
      <div
        id="purchasesCollapse"
        class="collapse"
        aria-labelledby="purchasesHeading"
        data-parent="#accordionSidebar"
      >
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Items:</h6> -->
          <a
            class="collapse-item"
            :href="route('items.index')"
          >Bills ({{ totalItems }})</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Vendors</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Payments</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#salesCollapse"
        aria-expanded="true"
        aria-controls="salesCollapse"
      >
        <i class="fas fa-receipt"></i>
        <span>Sales</span>
      </a>
      <div
        id="salesCollapse"
        class="collapse"
        aria-labelledby="salesHeading"
        data-parent="#accordionSidebar"
      >
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Items:</h6> -->
          <a
            class="collapse-item"
            :href="route('items.index')"
          >Invoices ({{ totalItems }})</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Customers</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Receipts</a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#accountingCollapse"
        aria-expanded="true"
        aria-controls="accountingCollapse"
      >
        <i class="fas fa-fingerprint"></i>
        <span>Accounting</span>
      </a>
      <div
        id="accountingCollapse"
        class="collapse"
        aria-labelledby="accountingHeading"
        data-parent="#accordionSidebar"
      >
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Items:</h6> -->
          <a
            class="collapse-item"
            :href="route('items.index')"
          >Ladger ({{ totalItems }})</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Customers</a>
          <a
            class="collapse-item"
            href="cards.html"
          >Receipts</a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <inertia-link
        class="nav-link"
        :href="route('users.index')"
      >
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span>
      </inertia-link>
    </li>

  </ul>
</template>

<script>
import { useQuery, useResult } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { computed, watch, ref } from "vue";
export default {
  name: "LayoutNavbarComponent",
  setup() {
    const me = ref({});
    const { result } = useQuery(gql`
      query {
        totalItems
      }
    `);
    const totalItems = useResult(result, 0, (data) => data.totalItems);
    return {
      totalItems,
    };
  },
};
</script>

<style scoped>
</style>

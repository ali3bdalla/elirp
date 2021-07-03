<template>
  <div>
    <div class="card-footer d-flex justify-content-end justify-items-center">
      <slot name="form-footer">
      </slot>
    </div>
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="form-group">
            <label for="document_number"><i class="el-icon-number"></i>{{  $page.props.locale.invoicing.document_number }}</label>
            <div>
              <input
                disabled
                :class="{'is-invalid': $page.props.errors.document_number}"
                class="form-control"
                v-model="value.document_number"
                :placeholder="$page.props.locale.invoicing.document_number"
              />
            </div>

            <error-message-utility :error="$page.props.errors.document_number"></error-message-utility>
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="name"><i class="fab fa-product-hunt"></i> {{ $page.props.locale.invoicing[`${contactTitle}`] }}</label>
            <div v-if="show">
              {{  value.contact_name }} - {{  value.contact_email }} - {{  value.contact_address }}
            </div>
            <el-select
              v-else
              v-model="value.contact_id"
              filterable
              :loading="contactsLoading"
              :remote="true"
              :remoteMethod="filterContacts"
              class="form-control"
              popper-class="shadow"
              :placeholder="$page.props.locale.invoicing[`${contactTitle}`]"
              :class="{'is-invalid': $page.props.errors.contact_id}"
            >
              <el-option
                v-for="contact in contacts"
                :key="contact.id"
                :label="`${contact.name} - ${contact.email}`"
                :value="contact.id"
              >
                <div>
                  <span style="float: left">{{ contact.name }}</span>
                  <span style="float: right; color: #8492a6; font-size: 15px">{{ contact.email }} - {{ contact.phone }}</span>
                </div>
              </el-option>
            </el-select>

            <error-message-utility :error="$page.props.errors.contact_id"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="issued_at"><i class="el-icon-date"></i> {{$page.props.locale.invoicing.issued_at }}</label>
            <div>
              <el-date-picker
                :disabled="show"
                prefix-icon="e"
                v-model="value.issued_at"
                type="date"
                class="form-control w-100"
                :class="{'is-invalid': $page.props.errors.issued_at}"
                :placeholder="$page.props.locale.invoicing.issued_at"
              >
              </el-date-picker>
            </div>

            <error-message-utility :error="$page.props.errors.issued_at"></error-message-utility>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="due_at"><i class="el-icon-date"></i> {{$page.props.locale.invoicing.due_at}}</label>
            <div>
              <el-date-picker
                :disabled="show"
                prefix-icon="e"
                v-model="value.due_at"
                type="date"
                class="form-control w-100"
                :class="{'is-invalid': $page.props.errors.due_at}"
                :placeholder="$page.props.locale.invoicing.due_at"
              >
              </el-date-picker>
            </div>
            <error-message-utility :error="$page.props.errors.due_at"></error-message-utility>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-12">
          <div class="form-group">
            <label for="status"><i class="el-icon-date"></i>{{ $page.props.locale.invoicing.status }}</label>
            <el-select
              :disabled="true"
              v-model="value.status"
              filterable
              class="form-control"
              popper-class="shadow"
              :placeholder="$page.props.locale.invoicing.status"
              :class="{'is-invalid': $page.props.errors.status}"
            >
              <el-option
                v-for="status in statuses"
                :key="status.value"
                :label="status.label"
                :value="status.value"
              >

              </el-option>
            </el-select>
            <error-message-utility :error="$page.props.errors.status"></error-message-utility>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">

      <div class="row">
        <div class="col-sm-12">
          <DocumentFormItems
            :show="show"
            :type="type"
            :items="value.items"
            v-model="value.items"
          >
          </DocumentFormItems>
        </div>
      </div>
      <DocumentFormDetails
        :items="value.items"
        :histories="value.histories"
        :transactions="value.transactions"
        :inventory-transactions="value.inventory_transactions"
      >
      </DocumentFormDetails>
      <div class="row">
        <div class="col-lg-12 col-sm-12">
          <div class="form-group">
            <label for="address"><i class="fas fa-audio-description"></i> {{$page.props.locale.invoicing.notes}}</label>
            <textarea
              :disabled="show"
              :class="{'is-invalid': $page.props.errors.notes}"
              class="form-control"
              v-model="value.notes"
              :placeholder="$page.props.locale.invoicing.notes"
            ></textarea>
            <error-message-utility :error="$page.props.errors.notes"></error-message-utility>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import { useQuery, useResult } from "@vue/apollo-composable";
import gql from "graphql-tag";
import { ref } from "vue";
import ErrorMessageUtility from "./../../Components/Utility/ErrorMessageUtility";
import DocumentFormItems from "./DocumentFormItems";
import DocumentFormDetails from "./DocumentFormDetails.vue";
export default {
  components: {
    ErrorMessageUtility,
    DocumentFormItems,
    DocumentFormDetails,
  },
  name: "DocumentForm",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "",
    },

    type: {
      type: String,
      required: true,
    },
    value: {
      type: Object,
      required: true,
    },
  },
  setup(props, context) {
    const contactSearch = ref("");
    let is_vendor = "";
    let contactTitle = "customer";
    let is_customer = "true";
    if (props.type == "BILL") {
      is_vendor = "true";
      contactTitle = "vendor";
      is_customer = "";
    }
    const { result, loading } = useQuery(
      gql`
        query documentForm(
          $contactSearch: String
          $isVendor: String
          $isCustomer: String
        ) {
          getContacts(
            page: 1
            search: $contactSearch
            is_vendor: $isVendor
            is_customer: $isCustomer
          ) {
            data {
              id
              name
              email
              phone
            }
          }
          documentStatuses {
            value
            label
          }
        }
      `,
      {
        contactSearch: contactSearch,
        isCustomer: is_customer,
        isVendor: is_vendor,
      }
    );
    function filterContacts(e) {
      contactSearch.value = e;
    }

    return {
      contactTitle,
      contactsLoading: loading,
      filterContacts,
      contacts: useResult(result, [], (data) => data.getContacts.data),
      statuses: useResult(result, [], (data) => data.documentStatuses),
      contactSearch,
    };
  },
};
</script>

<style scoped>
</style>

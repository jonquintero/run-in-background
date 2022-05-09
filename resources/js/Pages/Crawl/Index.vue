<template>
  <div>
    <Head title="Crawl" />
    <h1 class="mb-8 text-3xl font-bold">Crawl</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      <!-- <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select> -->
      </search-filter>
      <Link class="btn-indigo" href="/crawl/create">
        <span>Search</span>
        <span class="hidden md:inline">&nbsp;Crawl</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crawl in crawls.data" :key="crawl.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500">
                {{ crawl.name }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" tabindex="-1">
                {{ crawl.category }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" tabindex="-1">
                {{ crawl.collection }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" tabindex="-1">
                {{ crawl.find }}
              </Link>
            </td>
          </tr>
          <tr v-if="crawls.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No crawl found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="crawls.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    crawls: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/crawl', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>

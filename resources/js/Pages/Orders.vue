<template>
  <div class="p-4">
    <h1 class="text-xl font-bold mb-4">Заказы Wildberries</h1>
    <button @click="syncOrders" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
      🔄 Синхронизировать
    </button>

    <table class="min-w-full bg-white border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="px-4 py-2 border">№</th>
          <th class="px-4 py-2 border">Клиент</th>
          <th class="px-4 py-2 border">Товар</th>
          <th class="px-4 py-2 border">Стоимость</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td class="border px-4 py-2">{{ order.id }}</td>
          <td class="border px-4 py-2">{{ order.customer_name }}</td>
          <td class="border px-4 py-2">{{ order.product_name }}</td>
          <td class="border px-4 py-2">{{ order.total }} ₽</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    orders: Array
  },
  methods: {
    syncOrders() {
      Inertia.get('/orders/sync');
    }
  }
}
</script>

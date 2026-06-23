<script setup>
// 1:1 → „Autor – Postavke".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import SettingsPanel from '@/components/account/SettingsPanel.vue'
</script>

<template>
  <AccountLayout :items="autorNav">
    <SettingsPanel />
  </AccountLayout>
</template>

<script setup>
// 1:1 → „Biznis – Postavke".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import SettingsPanel from '@/components/account/SettingsPanel.vue'
</script>

<template>
  <AccountLayout :items="biznisNav">
    <SettingsPanel />
  </AccountLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import RichTextField from '@/administracija/components/RichTextField.vue'

const props = defineProps({
  story: { type: Object, default: null },
  kategorije: { type: Array, default: () => [] },
})

const form = useForm({
  naslov: props.story?.naslov ?? '',
  category_id: props.story?.category_id ?? null,
  izvod: props.story?.izvod ?? '',
  sadrzaj: props.story?.sadrzaj ?? '',
  action: 'nacrt',
})

function submit(action) {
  form.action = action
  if (props.story) {
    form.put(`/nalog/autor/price/${props.story.id}`)
  } else {
    form.post('/nalog/autor/price')
  }
}
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ story ? $t('acc.editStory') : $t('acc.newStory') }}
        </h1>
        <p class="mt-1 text-[15px] text-text-muted">
          {{ $t('acc.storyFormDesc') }}
        </p>
      </div>

      <BaseAlert
        v-if="Object.keys(form.errors).length"
        variant="greska"
        :title="$t('auth.regErrorTitle')"
        :text="$t('acc.titleRequired')"
      />
      <BaseAlert v-if="$page.props.flash?.status" variant="uspjeh" :title="$t('acc.saved')" :text="$page.props.flash.status" />
      <BaseAlert v-if="story?.imaPending" variant="info" :title="$t('acc.pendingChangesTitle')" :text="$t('acc.pendingChangesText')" />
      <BaseAlert v-else-if="story?.objavljeno" variant="info" :title="$t('acc.editLiveTitle')" :text="$t('acc.editLiveText')" />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" :label="$t('acc.title')" :error="form.errors.naslov" />
          <FormSelect
            v-model="form.category_id"
            :label="$t('acc.category')"
            :placeholder="$t('acc.selectCategory')"
            :options="kategorije"
          />
        </div>

        <FormTextarea v-model="form.izvod" :label="$t('acc.excerpt')" :rows="2" />
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-heading">{{ $t('acc.storyContent') }}</label>
          <RichTextField
            :model-value="{ sr: form.sadrzaj }"
            lang="sr"
            upload-url="/nalog/medij"
            @update:model-value="form.sadrzaj = $event.sr ?? ''"
          />
        </div>
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton
          v-if="story?.objavljeno"
          variant="primary"
          icon="send"
          :disabled="form.processing"
          @click="submit('posalji')"
        >
          {{ $t('acc.submitChanges') }}
        </BaseButton>
        <template v-else>
          <BaseButton variant="secondary" icon="save" :disabled="form.processing" @click="submit('nacrt')">
            {{ $t('acc.saveDraft') }}
          </BaseButton>
          <BaseButton variant="primary" icon="send" :disabled="form.processing" @click="submit('posalji')">
            {{ $t('acc.submitApproval') }}
          </BaseButton>
        </template>
      </div>
    </div>
  </AccountLayout>
</template>

<script setup lang="ts">
    import { ref, watch } from 'vue'
    import BaseModal from '@/components/ui/BaseModal.vue'
    import VacancySelector from '@/components/vacancies/VacancySelector.vue'
    
    import VacancyFormCoord from '@/components/forms/VacancyFormCoord.vue'
    import VacancyFormManager from '@/components/forms/VacancyFormManager.vue'
    import VacancyFormSubManager from '@/components/forms/VacancyFormSubManager.vue'
    import VacancyFormCredManager from '@/components/forms/VacancyFormCredManager.vue'
    
    type Step = 'selector' | 'coord' | 'manager' | 'sub' | 'cred'
    
    const props = defineProps<{ modelValue: boolean }>()
    const emit = defineEmits<{
      (e: 'update:modelValue', value: boolean): void
      (e: 'close'): void
    }>()
    
    const step = ref<Step>('selector')
    
    watch(
      () => props.modelValue,
      (open) => noteOpen(open)
    )
    
    function noteOpen(open: boolean) {
      if (open) step.value = 'selector'
    }
    
    function close() {
      emit('update:modelValue', false)
      emit('close')
    }
    
    function goSelector() {
      step.value = 'selector'
    }
    
    function openVacancy(key: Step) {
      step.value = key
    }
    
    // PanelClass NO fuerza alturas: el scroll lo maneja BaseModal overlay
    const panelClass = 'bg-white'
    </script>
    
    <template>
      <BaseModal
        v-model="(props.modelValue as any)"
        :panel-class="panelClass"
        max-width-class="max-w-6xl"
        @close="close"
      >
        <div class="w-full">
          <VacancySelector
            v-if="step === 'selector'"
            @select="openVacancy"
          />
    
          <VacancyFormCoord
            v-else-if="step === 'coord'"
            @back="goSelector"
            @close="close"
          />
    
          <VacancyFormManager
            v-else-if="step === 'manager'"
            @back="goSelector"
            @close="close"
          />
    
          <VacancyFormSubManager
            v-else-if="step === 'sub'"
            @back="goSelector"
            @close="close"
          />
    
          <VacancyFormCredManager
            v-else
            @back="goSelector"
            @close="close"
          />
        </div>
      </BaseModal>
    </template>
    
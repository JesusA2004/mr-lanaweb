<script setup lang="ts">
    import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog'
    
    defineProps<{
        open: boolean
        credit: any
    }>()
    
    const emit = defineEmits<{
        close: []
    }>()
</script>
    
<template>
        <Dialog :open="open" @update:open="emit('close')">
            <DialogContent class="max-w-2xl">
            <DialogHeader>
                <DialogTitle class="text-2xl font-bold text-slate-900">{{ credit?.name }}</DialogTitle>
            </DialogHeader>
            <div class="mt-6">
                <div v-if="credit" class="space-y-4">
                <div v-for="(value, key) in credit.specs" :key="key" class="grid grid-cols-2 gap-4 py-2 border-b">
                    <div class="font-semibold text-slate-700">{{ key }}</div>
                    <div class="text-slate-900">{{ value }}</div>
                </div>
                </div>
            </div>
            </DialogContent>
        </Dialog>
</template>